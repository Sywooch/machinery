<?php

namespace common\modules\product\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\data\ActiveDataProvider;
use frontend\modules\catalog\components\FilterParams;

/**
 * ProductDefaultSearch represents the model behind the search.
 */
class ProductRepository extends \backend\models\ProductSearch
{
    const PUBLISH = 1;
    
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
     * @param array $ids
     * @return mixed
     */
    public function getProductsByGroup($groups){
        $model = $this->_model;
        return $model::find()->where(['group' => $groups])
                ->with([
                    'files',
                    'alias',
                    'groupAlias'
                ])
                ->groupBy('group')->all();
    }
   
        
    public function getGroupRatingByModel($model){
        $query = (new \yii\db\Query())
                ->from($model::tableName())
                ->where([
                    'group' => $model->group,
                ])->andWhere(['>', 'rating', 0]);
        
        return $query->average('rating');
    }

    /**
     * 
     * @return \backend\models\ProductSearch
     */
    public function searchItemsByFilter($filter){
        $query = (new \yii\db\Query())
                        ->select(['t0.id'])
                        ->from($this->_model->tableName().' as t0')
                        ->distinct()
                        ->orderBy([
                            'rating' => SORT_DESC
                        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['catalog']['defaultPageSize'],
            ],
            'key' => 'id',

        ]);
        
        $where = [];
        $indexModel = $this->_indexModel;
        $indexTable = $indexModel::tableName();
        foreach($filter->getTerms([$filter->main]) as $id => $value){
            $query->innerJoin($indexTable . " {$indexTable}{$id}", "{$indexTable}{$id}.entity_id = t0.id");
            $where["{$indexTable}{$id}.term_id"] = is_array($value) ? ArrayHelper::getColumn($value, 'id') : $value->id;
        }
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
        $indexModel = $this->_indexModel;
        return (new \yii\db\Query())
                        ->select('t0.id')
                        ->from($this->_model->tableName().' as t0')
                        ->innerJoin($indexModel::tableName(), 'entity_id = t0.id')
                        ->where([
                            'term_id' => $taxonomyItem->id,
                            'publish' => self::PUBLISH,
                            
                        ])
                        ->groupBy('group')
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
        
        $indexModel = $this->_indexModel;
        return (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->innerJoin($indexModel::tableName(), 'entity_id = id')
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
