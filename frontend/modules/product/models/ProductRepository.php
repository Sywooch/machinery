<?php

namespace frontend\modules\product\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
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
        $model = $this->_model;
        return $model::findAll($ids);
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
     * @param int $groupId
     * @return array
     */
    public function getProductsByGroup($groupId){
        $model = $this->_model;
        return $model::find()->where(['group' => $groupId])->all();
    }
    
    /**
     * 
     * @param array $ids
     * @return mixed
     */
    public function getProducstsByGroups(array $groups){
        $model = $this->_model;
        return $model::find()->where(['group' => $groups])->groupBy('group')->all();
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
    public function searchItemsByFilter(FilterParams $filter){

        $query = (new \yii\db\Query())
                        ->select(['group'])
                        ->from($this->_model->tableName())
                        ->distinct()
                        ->orderBy([
                            'rating' => SORT_DESC
                        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['catalog']['defaultPageSize'],
            ],
            'key' => 'group',

        ]);
        
        $where = null;
        $indexModel = $this->_indexModel;
        $indexTable = $indexModel::tableName();
        foreach($filter->index as $id => $value){
            $query->innerJoin($indexTable . " {$indexTable}{$id}", "{$indexTable}{$id}.entity_id = id");
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
    public function getCategoryMostRatedItems(TaxonomyItems $taxonomyItem, int $limit = 5){
        $indexModel = $this->_indexModel;
        return (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->innerJoin($indexModel::tableName(), 'entity_id = id')
                        ->where([
                            'term_id' => $taxonomyItem->id,
                            'publish' => self::PUBLISH,
                            
                        ])
                        ->groupBy('group')
                        ->limit($limit)
                        ->all();
    }
    
}
