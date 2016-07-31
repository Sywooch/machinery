<?php

namespace frontend\modules\catalog\models;

use Yii;
use frontend\modules\product\models\ProductSearch;
use common\modules\taxonomy\models\TaxonomyItems;

class FilterModel extends \yii\base\Model
{
    
    protected $_model;
    protected $_indexModel;

    public function __construct(ProductSearch $search) {
        $this->_model = $search->model;
        $this->_indexModel = $this->_model->className() . 'Index';
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
                            ->where(['entity_id' => $subQuery])
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
