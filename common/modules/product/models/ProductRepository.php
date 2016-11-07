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
    public function getProductsByIds(array $ids){
        if(empty($ids)){
            return [];
        }
        $model = $this->_model;
        return  $model::find()->where(['id' => $ids])
                ->with([
                    'terms',
                    'files',
                    'alias',
                    'groupAlias'  
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
                        ->select(['id'])
                        ->from($this->_model->tableName())
                        ->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['catalog']['defaultPageSize'],
            ],
            'key' => 'id',
        ]);
 
        $where = [];
        $index = ArrayHelper::map($filter->getTerms([$filter->main]),'id','id','vid');
        foreach($index as $id => $values){
            $where[] = 'index && ARRAY['.implode(',', $values).']';
        }
        
        $query->where(implode(' AND ', $where));
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
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->where(['&&', 'index', new \yii\db\Expression('ARRAY['.$taxonomyItem->id.']')])
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
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->where(['&&', 'index', new \yii\db\Expression('ARRAY['.$status->id.']')])
                        ->limit($limit)
                        ->column();
    }
    
    /**
     * 
     * @param int $limit
     * @return []
     */
    public function getItemsDiscount($limit = 10){
        
        return (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->where(['>', 'old_price', 0])
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
