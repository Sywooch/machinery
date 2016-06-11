<?php

namespace frontend\modules\product\models;

use Yii;
use yii\data\Pagination;
use common\modules\taxonomy\models\TaxonomyItems;

/**
 * ProductPhoneSearch represents the model behind the search.
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
     * @param array $params
     * @return \backend\models\ProductSearch
     */
    public function searchItemsByParams($params){
        $this->load($params);
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

}
