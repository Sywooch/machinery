<?php

namespace common\modules\product\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\data\ActiveDataProvider;
use common\modules\product\models\ProductIndex;
use common\modules\product\models\ProductIndexPivot;

/**
 * ProductDefaultSearch represents the model behind the search.
 */
class ProductRepository extends \backend\models\ProductSearch
{
    const PUBLISH = 1;
    
    public function __construct($model) {
        parent::__construct($model);
    }

        /**
     * 
     * @param array $ids
     * @return mixed
     */
    public function getProducstByIds(array $ids){
        if(empty($ids)){
            return [];
        }
        $model = $this->_model;
        return $model::find()->where(['id' => $ids])
                ->with([
                    'files',
                    'alias',
                    'groupAlias',
                    'terms'
                ])->all();
    }
    
    /**
     * 
     * @param int $id
     * @return object
     */
    public function getProductById($id){
        $model = $this->_model;
        return $model::findOne($id);
    }
    
    /**
     * 
     * @param string|array $groups
     * @return type
     */
    public function getProductsByGroup($groups){
        $model = $this->_model;
        
        return (new \yii\db\Query())
                        ->select(['t0.id'])
                        ->from($this->_model->tableName().' as t0')
                        ->where(['group' => $groups])
                        ->distinct()
                        ->column();
    }
   
    /**
     * 
     * @return \backend\models\ProductSearch
     */
    public function searchItemsByFilter($filter){
        
      
        $query = (new \yii\db\Query())
                        ->select(['t0.id'])
                        ->from($this->_model->tableName().' as t0')
                        ->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['catalog']['defaultPageSize'],
            ],
            'key' => 'id',
        ]);
 
        $where = [];
        $indexTable = $this->_model->indexModel->tableName();
        $index = ArrayHelper::map($filter->getTerms([$filter->main]),'id','id','vid');
        foreach($index as $id => $values){
            $query->innerJoin($indexTable . " {$indexTable}{$id}", "{$indexTable}{$id}.entity_id = t0.id");
            $where["{$indexTable}{$id}.term_id"] = $values;
        }
        
        //print_r($where); exit('s');

        $query->andFilterWhere($where);
        return $dataProvider;
        
    }
    
    /**
     * 
     * @param TaxonomyItems $taxonomyItem
     * @param int $limit
     * @return \backend\models\ProductSearch
     */
    public function getCategoryMostRatedItems(TaxonomyItems $taxonomyItem, $limit = 5){

        return (new \yii\db\Query())
                        ->select('t0.id')
                        ->from($this->_model->tableName().' AS t0')
                        ->innerJoin($this->_model->indexModel->tableName(), 'entity_id = t0.id')
                        ->where([
                            'term_id' => $taxonomyItem->id
                        ])
                        ->distinct()
                        ->limit($limit)
                        ->all();
    }
    
    /**
     * 
     * @param TaxonomyItems $status
     * @param int $limit
     * @return []
     */
    public function getItemsByStatus(TaxonomyItems $status, $limit = 10){
        
        return (new \yii\db\Query())
                        ->select('t0.id')
                        ->from($this->_model->tableName().' t0')
                        ->innerJoin($this->model->indexModel->tableName(), 'entity_id = t0.id')
                        ->where([
                            'term_id' => $status->id
                        ])
                        ->limit($limit)
                        ->column();
    }


    /**
     * 
     * @param array $status
     * @param int $limit
     * @return array
     */
    public function getReindexItems(array $status, $limit){
        $model = $this->_model;

        return (new \yii\db\Query())
                        ->select('
                            id,
                            group,
                            model,
                            source_id,
                            user_id,
                            sku,
                            available,
                            price,
                            rating,
                            publish,
                            `reindex` + 0 as reindex,
                            crc32,
                            crc32_reindex,
                            title,
                            description,
                            data'
                        )
                        ->from($model::tableName())
                        ->where(['reindex' => $status])
                        ->limit($limit)
                        ->all();
    }
    
    
    /**
     * 
     * @param int $status
     * @param [] $ids
     * @return boolean
     */
    public function setReindexStatus($status, $ids){
        if(empty($ids)){
            return false;
        }
        $model = $this->_model;
        Yii::$app->db->createCommand("UPDATE ".$model::tableName()." SET reindex={$status}, crc32_reindex=crc32 WHERE id IN (".implode(',', $ids).")")->execute();
    }
    
}
