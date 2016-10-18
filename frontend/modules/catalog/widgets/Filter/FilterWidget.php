<?php
namespace frontend\modules\catalog\widgets\Filter;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\components\CatalogUrlRule;
use frontend\modules\catalog\models\FilterModel;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use frontend\modules\catalog\components\FilterParams;

class FilterWidget extends \yii\bootstrap\Widget
{
    const CACHE_TIME = 60*60*5;
    
    public $search;
    public $url;
    private $_model;
    private $_vocabularies;


    public function init(){
       if(!$this->url){
           $this->url = Yii::$app->url;
       }
       if($this->search){
           $this->_model = new FilterModel($this->search);
       }
    }
    
    public function run()
    {    
        return $this->getFilteForm();
    }
    
    /**
     * 
     * @return array
     */
    public function getVocabularies(){
        if(!empty($this->_vocabularies)){
            return $this->_vocabularies;
        }
        
        $this->_vocabularies =  TaxonomyVocabulary::find()
                ->indexBy('id')
                ->orderBy(['weight' => SORT_ASC])
                ->all();
        
        return $this->_vocabularies;
    }


    /**
     * 
     * @return mixed
     */
    private function getFilteForm(){
        $filterTerms = $this->getFilterTermsByTerm($this->url->main);
        if(empty($filterTerms)){
            return;
        }
        
        $filterItemsCount = []; //$this->_model->getCountFilterTerms($terms); //TODO: uncomment
        
        return $this->render('filter-widget', [
                'filterItems' => ArrayHelper::index($filterTerms,'id', 'vid'),
                'filterItemsCount' => $filterItemsCount,
                'vocabularies' => $this->vocabularies,
                'model' => $this->_model,
                'filter' => $this->url
        ]);
    }

    private function getFilterTermsByTerm(TaxonomyItems $term){
        $filterTerms = Yii::$app->cache->get("filter:catalog:{$term->id}");
        if ($filterTerms === false) {

            $filterTermIds = $this->_model->getFilterTermIds($term);
        
            if(!$filterTermIds){
                return;
            }

            $filterTerms = ArrayHelper::index(TaxonomyItems::findAll($filterTermIds), 'id');
            
            Yii::$app->cache->set("filter:catalog:{$term->id}", $filterTerms, self::CACHE_TIME);
        }
        return $filterTerms;
    }
}
