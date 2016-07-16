<?php

namespace frontend\modules\product\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\file\models\File;
use frontend\modules\catalog\components\FilterParams;

/**
 * ProductDefaultSearch represents the model behind the search.
 */
class ProductSearch extends \backend\models\ProductSearch
{
    const PUBLISH = 1;
    
    private $_items;
    private $_pages;

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
        
        return $this->_model::findAll($this->_items);
    }
    
    /**
     * 
     * @return object
     */
    public function getProduct(){
        if(empty($this->_items)){
            return [];
        }
        return $this->_model::findOne($this->_items);
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
     * @return \backend\models\ProductSearch
     */
    public function searchItemsByFilter(FilterParams $filter){

        $query = (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->where([
                            'publish' => self::PUBLISH,
                        ])
                        ->distinct();
        $where = null;
        foreach($filter->index as $id => $value){
            $query->innerJoin($this->_indexModel::tableName(). " i{$id}", "i{$id}.entity_id = id");
            $where["i{$id}.term_id"] = is_array($value) ? ArrayHelper::getColumn($value, 'id') : $value->id;
        }
        
        $query->andFilterWhere($where);

        $countQuery = clone $query;
        $this->_pages =  new Pagination([
                'totalCount' => $countQuery->count(), 
                'defaultPageSize' => Yii::$app->params['catalog']['defaultPageSize']
            ]);
        $this->_items = $query->offset($this->_pages->offset)
                ->limit($this->_pages->limit)
                ->column();
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
  
}
