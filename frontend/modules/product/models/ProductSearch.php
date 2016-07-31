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
class ProductSearch extends \backend\models\ProductSearch
{
    const PUBLISH = 1;
    
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
     * @return \backend\models\ProductSearch
     */
    public function searchItemsByFilter(FilterParams $filter){

        $query = $this->_model->find()
                        ->where([
                            'publish' => self::PUBLISH,
                        ])
                        ->distinct();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['catalog']['defaultPageSize'],
            ],
            'key' => 'id',

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
        $this->_items = (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->innerJoin($indexModel::tableName(), 'entity_id = id')
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
