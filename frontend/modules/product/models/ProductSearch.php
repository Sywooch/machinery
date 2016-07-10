<?php

namespace frontend\modules\product\models;

use Yii;
use yii\data\Pagination;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\helpers\ArrayHelper;

/**
 * ProductDefaultSearch represents the model behind the search.
 */
class ProductSearch extends \backend\models\ProductSearch
{
    const PUBLISH = 1;
    
    private $_items;
    private $_pages;
    private $_product;
    private $_products = [];

    /**
     * 
     * @return type
     */
    public function getItems(){
       return $this->_items;
    }
    
    /**
     * 
     * @return type
     */
    public function getPages(){
        return $this->_pages;
    }
    
    /**
     * 
     * @return []
     */
    public function getProducts(){
        if(empty($this->_items)){
            return [];
        }
        return $this->_model::find(['id' => $this->_items])->all();
    }
    
    /**
     * 
     * @return object
     */
    public function getProduct(){
        if(empty($this->_items)){
            return [];
        }
        return $this->_model::findOne(['id' => $this->_items]);
    }
    
    /**
     * 
     * @param int $id
     * @return object
     */
    public function getProductById($id){
        return $this->_model::findOne($id);
    }

    /**
     * 
     * @param array $params
     * @return boolean
     */
    public function setParams(array $params){
        $this->load($params);
        if (!$this->validate()) {
          return false;
        }
        return true;
    }


    /**
     * 
     * @return \backend\models\ProductSearch
     */
    public function searchItemsByParams(){
        if (!$this->validate()) {
            return [];
        }

        $query = (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->innerJoin($this->_indexModel::tableName(), 'entity_id = id')
                        ->where([
                            'publish' => self::PUBLISH,
                        ])
                        ->andFilterWhere([
                            'term_id' => $this->index
                        ])
                        ->distinct();
        
        $countQuery = clone $query;
        $this->_pages =  new Pagination([
                'totalCount' => $countQuery->count(), 
                'defaultPageSize' => Yii::$app->params['catalog']['defaultPageSize']
            ]);
        $this->_items = $query->offset($this->_pages->offset)
                ->limit($this->_pages->limit)
                ->all();
        
        return $this;
    }
    
    /**
     * 
     * @param TaxonomyItems $taxonomyItem
     * @param int $limit
     * @return \backend\models\ProductSearch
     */
    public function getCategoryMostRatedItems(TaxonomyItems $taxonomyItem, int $limit = 5){
        $this->_items = (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->innerJoin($this->_indexModel::tableName(), 'entity_id = id')
                        ->where([
                            'term_id' => $taxonomyItem->id,
                            'publish' => self::PUBLISH,
                            
                        ])
                        ->distinct()
                        ->limit($limit)
                        ->all();
        return $this;
    }
    
    /**
     * 
     * @param int $catalogId
     * @return []
     */
    public function getFilterTermIds(TaxonomyItems $catalogTerm){

            $subQuery = (new \yii\db\Query())
                        ->select('entity_id')
                        ->from($this->_indexModel::tableName())
                        ->where(['term_id' => $catalogTerm->id])
                        ->distinct();
        
            return  (new \yii\db\Query())
                            ->select('term_id as id')
                            ->from($this->_indexModel::tableName())
                            ->where(['entity_id' => $subQuery])
                            ->distinct()
                            ->column();  
    }
    
    public function getCountFilterTerms(array $data){
        if(empty($data)){
            return [];
        }
        $data = ArrayHelper::map($data, 'id', 'id', 'vid');
        $subQuery = (new \yii\db\Query())
                        ->select('entity_id')
                        ->from($this->_indexModel::tableName())
                        ->innerJoin(TaxonomyItems::TABLE_TAXONOMY_ITEMS, 'id = term_id')
                        ->distinct();
        $where = [];
        foreach($data as $vocabularyId => $termIds){
            $where[] = "vid = '{$vocabularyId}' AND term_id IN (" . implode(',', $termIds) . ")";
        }
        
        $subQuery->where('(' . implode(') OR (', $where) . ')');
        
        return  (new \yii\db\Query())
                        ->select('count(entity_id) as items, term_id')
                        ->from($this->_indexModel::tableName())
                        ->where(['entity_id' => $subQuery])
                        ->indexBy('term_id')
                        ->groupBy('term_id')
                        ->column();
                       // ->createCommand()->getRawSql();    
        
    }
    
}
