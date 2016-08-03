<?php

namespace common\modules\import\components;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\import\helpers\ImportHelper;
use frontend\modules\catalog\helpers\CatalogHelper;
use common\models\Alias;
use common\modules\import\models\Validate;
use common\modules\import\components\Reindex;
use yii\base\InvalidValueException;

/**
*
 */
class Insert extends \yii\base\Model
{
    const INSERT_LIMIT  = 1000;
    
    private $stack = [];
    private $model;

    /**
     * @param Validate $data
     */
    public function add(Validate $validate){
        $data = $validate->attributes;
        $data['data'] = json_encode($validate->attributes);
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
        $this->model = CatalogHelper::getModelByTerm(TaxonomyItems::findOne($currentCatalogId));
        $this->insertBatch($this->model->tableName(), $items, ImportHelper::productFields(), ImportHelper::productFieldTypes());
        $sku2Ids = $this->getIdsBySku(array_column($items, 'sku'));
       
        /**
         * Url
         */
        if(method_exists($this->model, 'urlImportPattern')){
            $model = $this->model;
            $insertUrlData = ImportHelper::insetUrlData($model, $model::urlImportPattern($items, $sku2Ids));
            $this->insertBatch(Alias::TABLE_ALIAS, $insertUrlData, ImportHelper::importUrlFields(), ImportHelper::importUrlFieldTypes());
            unset($insertUrlData);
        }
        
        /*
         * terms
         */
        $currentTermIds = $this->getTermIdsByProdutIds($sku2Ids);
        $newTermIds = array_column($items, 'terms', 'sku');
        $insetTermsData = ImportHelper::insetTermsData($sku2Ids, $currentTermIds, $newTermIds);
        $deleteTermsData = ImportHelper::deleteTermsData($sku2Ids, $currentTermIds, $newTermIds);
        $indexModel = $this->model->className() . 'Index';
        $this->insertBatch($indexModel::tableName(), $insetTermsData, ImportHelper::termFields(), ImportHelper::termFieldTypes());
        $this->deleteIndex($indexModel::tableName(), $deleteTermsData);
        
    }
    
    private function deleteIndex($table, array $items){
        if(empty($items)){
            return;
        }
        $where = [];
        foreach($items as $entityId => $termsIds){
            $temporary = 'entity_id = '.$entityId;
            if(!empty($termsIds)){
                $temporary .= ' AND term_id IN ('.implode(',', $termsIds).')';
            }
            $where[] = "({$temporary})";
        }
        return (new \yii\db\Query())->createCommand()->delete($table, implode(' OR ', $where))->execute();
    }


    private function getIdsBySku(array $sku){
        return (new \yii\db\Query())
                        ->select(['id','sku'])
                        ->from($this->model->tableName())
                        ->indexBy('sku')
                        ->where([
                            'sku' => $sku,
                        ])->column();
    }
    
    private function getTermIdsByProdutIds(array $ids){
        $data = [];
        $model = $this->model->className() . 'Index';
        $items = (new \yii\db\Query())
                        ->select(['entity_id','term_id'])
                        ->from($model::tableName())
                        ->where([
                            'entity_id' => $ids,
                        ])->all();
        foreach($items as $item){
            $data[$item['entity_id']][] = $item['term_id'];
        }
        return $data;
    }

    public function insertBatch($table, array $data, array $columns, array $types){

        if (!$table) {
            throw new InvalidValueException('Param $table can not be empty');
        }
        
        if (empty($columns)) {
            throw new InvalidValueException('Param $columns can not be empty');
        }

        if (empty($data)) {
            throw new InvalidValueException('Param $data can not be empty');
        }
        
        if (empty($types)) {
            throw new InvalidValueException('Param $types can not be empty');
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
            if($column == 'crc32'){
                $onDuplicateStrings[] = '`reindex` =  ' . Reindex::REINDEX;
            }
            $onDuplicateStrings[] = '`'.$column.'` = VALUES(`'.$column.'`) ';
        }
        
        $sql = Yii::$app->db->queryBuilder->batchInsert($table, $columns, array_chunk($params, $countColumns));
       
        return Yii::$app->db->createCommand($sql . " ON DUPLICATE KEY UPDATE ".implode(',', $onDuplicateStrings))->execute();

    }

}
