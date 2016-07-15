<?php
namespace frontend\modules\catalog\widgets\Filter;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\helpers\UrlHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;

class FilterWidget extends \yii\bootstrap\Widget
{
    public $search; 
    private $urlHelper;

    public function init(){
        parent::init();
        $this->urlHelper = new UrlHelper();   
    }

    public function run()
    {
  
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
        $vocabularies = TaxonomyVocabulary::find()->indexBy('id')->all();
        $vocabulariesPrefixes = ArrayHelper::getColumn($vocabularies, 'prefix');
        $filterCurrent = $this->urlHelper->parseUrlParams(Yii::$app->request->getPathInfo(), $vocabulariesPrefixes);

        if(!isset($filterCurrent[$catalogVocabularyId]) || !is_numeric($filterCurrent[$catalogVocabularyId])){
            return;
        }
        
        $catalogId = $filterCurrent[$catalogVocabularyId] = 11; // TODO: delete

        if(($catalogTerm = TaxonomyItems::findOne($catalogId)) === null){
            return;
        }

        $filterTerms = $this->getFilterTermsByTerm($catalogTerm);
        
        if(empty($filterTerms)){
            return;
        }
        
        $filterItemsCount = []; //$this->search->getCountFilterTerms($terms); //TODO: uncomment

        return $this->render('filter-widget', [
                'filterItems' => ArrayHelper::index($filterTerms,'id','vid'),
                'filterItemsCount' => $filterItemsCount,
                'filterCurrent' => $filterCurrent,
                'vocabulariesPrefixes' => $vocabulariesPrefixes,
                'vocabularies' => $vocabularies,
        ]);
    }
    
    private function getFilterTermsByTerm(TaxonomyItems $term){
        
        $filterTerms = Yii::$app->cache->get("filter:catalog:{$term->id}");

        if ($filterTerms === false) {

            $filterTermIds = $this->search->getFilterTermIds($term);
        
            if(!$filterTermIds){
                return;
            }

            $filterTerms = ArrayHelper::index(TaxonomyItems::findAll($filterTermIds), 'id');
            
            Yii::$app->cache->set("filter:catalog:{$term->id}", $filterTerms, 3600);
        }
        
        return $filterTerms;
        
    }
}
