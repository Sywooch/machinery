<?php
namespace common\modules\store\widgets\Filter;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\components\CatalogUrlRule;
use common\modules\store\models\FilterModel;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;
use frontend\modules\catalog\components\FilterParams;

class FilterWidget extends \yii\bootstrap\Widget
{
    const CACHE_TIME = 60*60*5;
    
    public $finder;
    public $url;
    
    private $_model;
    private $_vocabularySearch;
    private $_vocabularies;

    public function __construct(TaxonomyVocabularySearch $vocabularySearch, $config = array()) {
        $this->_vocabularySearch = $vocabularySearch; 
        parent::__construct($config);
    }

    public function init(){
       if($this->finder){
           $this->_model = new FilterModel($this->finder);
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
        return $this->_vocabularies = $this->_vocabularySearch->vocabularies;
    }


    /**
     * 
     * @return mixed
     */
    private function getFilteForm(){
        $filterTerms = $this->getFilterTermsByTerm($this->url->category);
        if(empty($filterTerms)){
            return;
        }

        return $this->render('filter-widget', [
                'filterItems' => ArrayHelper::index($filterTerms,'id', 'vid'),
                'filterItemsCount' => [],
                'vocabularies' => $this->vocabularies,
                'model' => $this->_model,
                'url' => $this->url
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
