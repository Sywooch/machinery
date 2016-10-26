<?php

namespace common\modules\import\components;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\import\helpers\ImportHelper;
use backend\models\ProductDefault;
use common\modules\import\models\Validate;
use common\modules\import\components\Reindex;
use yii\base\InvalidValueException;
use common\helpers\ModelHelper;

/**
*
 */
class Insert extends \yii\base\Model
{
    const INSERT_LIMIT  = 100;
    const TEMP_TABLE = 'temporary_entitys';
    
    private $stack = [];
    private $model;

    
    public function init(){

        Yii::$app->db->createCommand('DROP TABLE IF EXISTS "'.self::TEMP_TABLE.'" ')->execute();
        Yii::$app->db->createCommand('
            CREATE UNLOGGED TABLE "'.self::TEMP_TABLE.'" (
                LIKE '.ProductDefault::tableName().' INCLUDING DEFAULTS
            )')->execute();
        Yii::$app->db->createCommand('CREATE INDEX temp_sku_idx ON  "'.self::TEMP_TABLE.'" (sku)')->execute();
        Yii::$app->db->createCommand('ALTER TABLE "'.self::TEMP_TABLE.'" DROP COLUMN id RESTRICT')->execute();
        Yii::$app->db->createCommand('ALTER TABLE "'.self::TEMP_TABLE.'" ALTER COLUMN "index" TYPE integer[]')->execute();
    }

        /**
     * @param Validate $data
     */
    public function add(Validate $validate){
        $data = $validate->attributes;
        $dataDecode = $validate->attributes;
        $dataDecode['features'] = '';
        $dataDecode['terms'] = '';
        $data['data'] = json_encode($dataDecode);
        unset($dataDecode);
        $data['crc32'] = crc32($data['data']);
        $this->stack[$validate->catalogId][] = $data;
        if(count($this->stack[$validate->catalogId]) >= self::INSERT_LIMIT){
            $this->flush($validate->catalogId);
        }
    }

    /**
     * @param int $catalogId
     */
    public function flush($catalogId = null){
        if(empty($this->stack)){
            return;
        }
        foreach($this->stack as $currentCatalogId => $items){
           if(!$catalogId){
               $this->insert($currentCatalogId, $items);
               unset($this->stack[$currentCatalogId]);
           }elseif( $catalogId == $currentCatalogId){
               $this->insert($currentCatalogId, $items);
               unset($this->stack[$currentCatalogId]);
           } 
        }
    }
    
    private function insert($currentCatalogId, array $items){

        $this->model = ModelHelper::getModelByTerm(TaxonomyItems::findOne($currentCatalogId));
        $this->insertBatch(self::TEMP_TABLE, $items, ImportHelper::productFields());

        $this->up($this->model);
        
    }
    
    private function up($model){
        
        /*
        $updateFields = '';
        foreach(ImportHelper::productFields() as $field){
            $field = '"'.$field.'"';
            $updateFields .= $updateFields ? ',':'';
            $updateFields .= $field.' = t1.'.$field;
        }
        
        $sql = 'update '.$model->tableName().' as t0 set
		'.$updateFields.'
                from (SELECT "'.implode('","', ImportHelper::productFields()).'" from '.self::TEMP_TABLE.') as t1("'.implode('","', ImportHelper::productFields()).'") 
                where t1.sku = t0.sku;';
        
        Yii::$app->db->createCommand($sql)->execute(); 
         * 
         */
        
        $fields = ImportHelper::productFields();
        unset($fields[array_search('sku', $fields)]);
        $sql = 'insert into '.$model->tableName().'("'.implode('","', ImportHelper::productFields()).'")'.
                'select DISTINCT ON ("sku") "sku", "'.implode('","', $fields).'" from '.self::TEMP_TABLE.' WHERE sku NOT IN(SELECT sku FROM '.$model->tableName().')';
        Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->db->createCommand('TRUNCATE '.self::TEMP_TABLE.' RESTRICT')->execute();
    }


    public function insertBatch($table, array $data, array $columns){

        if (!$table) {
            throw new InvalidValueException('Param $table can not be empty');
        }
        
        if (empty($columns)) {
            throw new InvalidValueException('Param $columns can not be empty');
        }

        if (empty($data)) {
            throw new InvalidValueException('Param $data can not be empty');
        }

        $params = [];
        $sortedColumns = [];
        
        
        foreach($data as $values){
            foreach($values as $key => $value){
                if(in_array($key, $columns)){
                    $params[] = $value;
                    if(!in_array($key, $sortedColumns)){
                        $sortedColumns[] = $key;
                    }
                }
            }
        }
      
        $columns = $sortedColumns;
        unset($sortedColumns);

        $countData = count($data);
        $countColumns = count($columns);
       
        if(count($params) < $countData * $countColumns){
            throw new BadParam('Param $data is not valid');
        }
        /*
        $onDuplicateStrings = [];
        foreach ($columns as $column) {
            if($column == 'crc32'){
                $onDuplicateStrings[] = '`reindex` =  ' . Reindex::REINDEX;
            }
            $onDuplicateStrings[] = '`'.$column.'` = VALUES(`'.$column.'`) ';
        }*/
        $sql = Yii::$app->db->queryBuilder->batchInsert($table, $columns, array_chunk($params, $countColumns));
        return Yii::$app->db->createCommand($sql)->execute();

    }

}
