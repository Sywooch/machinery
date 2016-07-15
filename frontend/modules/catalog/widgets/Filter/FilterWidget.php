<?php
namespace frontend\modules\catalog\widgets\Filter;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\components\CatalogUrlRule;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;

class FilterWidget extends \yii\bootstrap\Widget
{
    public $search; 
    private $_urlRule;

    public function __construct(array $config = []) {
        $this->_urlRule = new CatalogUrlRule();
        parent::__construct($config);
    }

    public function run()
    {
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
        
        if(($filter = $this->_urlRule->parseUrl(Yii::$app->request->getPathInfo())) === false || !($filter[$catalogVocabularyId] instanceof TaxonomyItems)){
            return false;
        }
       
        $catalogTerm = $filter[$catalogVocabularyId] = TaxonomyItems::findOne(11); // TODO: delete

        $filterTerms = $this->getFilterTermsByTerm($catalogTerm);
        
        if(empty($filterTerms)){
            return;
        }
        
        $filterItemsCount = []; //$this->search->getCountFilterTerms($terms); //TODO: uncomment
        $vocabularies = TaxonomyVocabulary::find()->indexBy('id')->all();

        return $this->render('filter-widget', [
                'filterItems' => ArrayHelper::index($filterTerms,'id','vid'),
                'filterItemsCount' => $filterItemsCount,
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
