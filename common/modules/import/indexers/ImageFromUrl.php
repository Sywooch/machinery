<?php
namespace common\modules\import\indexers;

use Yii;
use common\modules\import\IndexerInterface;
use common\helpers\ModelHelper;
use common\modules\import\components\Insert;
use common\modules\import\components\Reindex;
use common\modules\import\models\ImportImage;

class ImageFromUrl implements IndexerInterface{

    private $stack = [];
    private $modelName;
    private $itemsFilePath;
    private $itemsFileDirectory;
    private $insert;


    public function __construct($model, Insert $insert) {
        $this->modelName = ModelHelper::getModelName($model);
        $this->itemsFilePath = Yii::getAlias('@app').'/../files/'.  strtolower($this->modelName);
        $this->itemsFileDirectory = 'files/'.  strtolower($this->modelName);
        $this->insert = $insert;
    }


    public function flush(){

        if(empty($this->stack)){
            return [];
        }

        $this->insert->insertBatch(ImportImage::tableName(), $this->stack, ['cr32','sku','data'], [\PDO::PARAM_INT, \PDO::PARAM_STR,\PDO::PARAM_STR]);
        $this->stack = [];        
    }

    /**
     * 
     * @param array $item
     * @return boolean
     */
    public function add($item){
       
        $copiedFiles = [];
        
        if($item['reindex'] != Reindex::NEW_ITEM){
            return false;
        }
        
        $data = json_decode($item['data']);
        
        if(!isset($data->images) || empty($data->images)){
           return false;
        }
        
        $copiedFiles = $this->prepare($item, $data->images);
        $this->stack = array_merge($this->stack, $copiedFiles);
        return true;
    }
    
    /**
     * 
     * @param int $item
     * @param array $images
     * @return array | bool
     */
    private function prepare($item, $images){
        $files = [];
        foreach($images as $field => $imageItems){
            foreach($imageItems as $image){
                
                if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                    continue;
                }

                $image = str_replace('/type1/', '/type8/', $image);
                $files[] = [
                    'cr32' => crc32 ( $item['sku'].$image ),
                    'sku' => $item['sku'],
                    'data' => json_encode( [
                                'entity_id' => $item['id'],
                                'field' => $field,
                                'model' => $this->modelName,
                                'path' => $this->itemsFileDirectory,
                                'name' => '',
                                'size' => 0,
                                'mimetype' => '',
                                'delta' => 0,
                                'url' => $image
                            ])
                ];
                
               
            }            
        }
        return $files;
    }
}
