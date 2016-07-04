<?php

namespace console\modules\import\models;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use console\modules\import\helpers\ImportHelper;
use frontend\modules\catalog\helpers\CatalogHelper;


/**
*
 */
class Insert extends \yii\base\Model
{
    const INSERT_LIMIT  = 3;
    
    private $stack = [];

    public function add(array $data){
        $catalogId = $data['termIds'][0]; 
        $this->stack[$catalogId][] = $data;
        if(count($this->stack[$catalogId]) >= self::INSERT_LIMIT){
            $this->flush($catalogId);
        }
    }

    public function flush($catalogId = null){
        if(empty($this->stack)){
            return;
        }
        foreach($this->stack as $currentCatalogId => $items){
           if(!$catalogId){
               $model = CatalogHelper::getModelByTerm(TaxonomyItems::findOne($currentCatalogId));
           }elseif( $catalogId == $currentCatalogId){
               $model = CatalogHelper::getModelByTerm(TaxonomyItems::findOne($currentCatalogId));
               $this->insertBatch($model->tableName(), $items, CatalogHelper::fields(), CatalogHelper::types());
           } 
        }
    }
    
    
    private function insertBatch($table, array $data, array $columns, array $types){

        if (!$table) {
            throw new ParamMiss('Param $table can not be empty');
        }
        
        if (empty($columns)) {
            throw new ParamMiss('Param $columns can not be empty');
        }

        if (empty($data)) {
            throw new ParamMiss('Param $data can not be empty');
        }
        
        if (empty($types)) {
            throw new ParamMiss('Param $types can not be empty');
        }
        

        
        $params = [];
        $paramsType = [];
        $sortedColumns = [];

        array_walk_recursive($data, function($value, $key) use (&$params, $types, &$paramsType, $columns, &$sortedColumns){
            if(!is_numeric($key) && in_array($key, $columns)){
               $params[] = $value;
               $paramsType[] = $types[$key];
               if(!in_array($key, $sortedColumns)){
                   $sortedColumns[] = $key;
               }
            }  
        });

        $columns = $sortedColumns;
        unset($sortedColumns);

        $countData = count($data);
        $countColumns = count($columns);
        
        if(count($params) < $countData * $countColumns){
            throw new BadParam('Param $data is not valid');
        }

        $onDuplicateStrings = [];
        foreach ($columns as $column) {
            $onDuplicateStrings[] = $column.' = VALUES('.$column.') ';
        }
        
        $sql = Yii::$app->db->queryBuilder->batchInsert($table, $columns, array_chunk($params, $countColumns));
        return Yii::$app->db->createCommand($sql . " ON DUPLICATE KEY UPDATE ".implode(',', $onDuplicateStrings))->execute();

    }

}
