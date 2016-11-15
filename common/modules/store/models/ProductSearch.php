<?php
namespace common\modules\store\models;

use yii\base\Object;
use yii\db\Expression;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\models\ProductBase;

class ProductSearch extends Object
{
    private $_model;
    
    
    public function setModel(ProductBase $model){
        $this->_model = $model;
    }

    public function getIdsByIndex(array $index){
        $query = (new \yii\db\Query())
                        ->select(['id'])
                        ->from($this->_model->tableName())
                        ->distinct();
        foreach($index as $values){
            $query->andWhere(['&&', 'index', new Expression('ARRAY['.implode(',', $values).']')]);
        }
        return $query->column();
    }
    
    public function findById(array $ids){
        return  $this->_model
                ->find()
                ->where(['id' => $ids]);
    }
    
    /**
     * 
     * @param TaxonomyItems $taxonomyItem
     * @param int $limit
     * @return mixed
     */
    public function getMostRatedId(TaxonomyItems $taxonomyItem, $limit = 5){

        return (new \yii\db\Query())
                        ->select('id')
                        ->from($this->_model->tableName())
                        ->where(['&&', 'index', new \yii\db\Expression('ARRAY['.$taxonomyItem->id.']')])
                        ->distinct()
                        ->limit($limit)
                        ->all();
    }

}
