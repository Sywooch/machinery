<?php

namespace frontend\modules\catalog\models;

use Yii;
use common\modules\product\models\ProductRepository;
use common\modules\taxonomy\models\TaxonomyItems;

class FilterModel extends \yii\base\Model
{
    
    protected $_model;
    protected $_indexModel;
    
    public $_priceRange = '250, 10000';
    public $_priceMin;
    public $_priceMax;
    public $index;

    public function __construct(ProductRepository $search = null) {
        if($search !== null){
            $this->_model = $search->model;
            $this->_indexModel = $this->_model->className() . 'Index';        
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priceMin', 'priceMax'], 'integer'],
            [['index'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'priceRange' => 'Подобрать по цене:',
        ];
    }
    
    /**
     * 
     * @return string
     */
    public function getPriceRange(){
        return implode(',', [$this->priceMin, $this->priceMax]);
    }
    
    
    /**
     * 
     * @return int
     */
    public function getPriceMin(){
        if($this->_priceMin === null){
           $this->_priceMin = 950;
        }
        return $this->_priceMin;
    }
    
    /**
     * 
     * @param int $price
     */
    public function setPriceMin($price){
        $this->_priceMin = $price;
    }
    
    /**
     * 
     * @return int
     */
    public function getPriceMax(){
        if($this->_priceMax === null){
           $this->_priceMax = 20000;
        }
        return $this->_priceMax;
    }
    
    /**
     * 
     * @param int $price
     */
    public function setPriceMax($price){
        $this->_priceMax = $price;
    }

    /**
     * 
     * @param int $catalogId
     * @return []
     */
    public function getFilterTermIds(TaxonomyItems $catalogTerm){

            $indexModel = $this->_indexModel;
            $subQuery = (new \yii\db\Query())
                        ->select('entity_id')
                        ->from($indexModel::tableName())
                        ->where(['term_id' => $catalogTerm->id])
                        ->distinct();
        
            return  (new \yii\db\Query())
                            ->select('term_id as id')
                            ->from($indexModel::tableName())
                            ->where([
                                'entity_id' => $subQuery,
                                'vocabulary_id' => Yii::$app->params['catalog']['filterVocabularyIds']
                            ])
                            ->distinct()
                            ->column();  
    }
    
    public function getCountFilterTerms(array $data){
        if(empty($data)){
            return [];
        }
        $indexModel = $this->_indexModel;
        $data = ArrayHelper::map($data, 'id', 'id', 'vid');
        $subQuery = (new \yii\db\Query())
                        ->select('entity_id')
                        ->from($indexModel::tableName())
                        ->distinct();
        $where = [];
        foreach($data as $vocabularyId => $termIds){
            $where[] = "term_id IN (" . implode(',', $termIds) . ") AND vocabulary_id = '{$vocabularyId}'";
        }
        
        $subQuery->where('(' . implode(') OR (', $where) . ')');
        
        return  (new \yii\db\Query())
                        ->select('count(entity_id) as items, term_id')
                        ->from($indexModel::tableName())
                        ->where(['entity_id' => $subQuery])
                        ->indexBy('term_id')
                        ->groupBy('term_id')
                        ->column();
                       // ->createCommand()->getRawSql();    
        
    }
}
