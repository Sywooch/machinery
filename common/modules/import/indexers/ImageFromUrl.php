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

        $this->insert->insertBatch(ImportImage::tableName(), $this->stack, ['data'], [\PDO::PARAM_STR]);
        $this->stack = [];        
    }

    /**
     * 
     * @param array $item
     * @return boolean
     */
    public function add($item){
       
        $copiedFiles = [];
        $data = json_decode($item['data']);
       
        if($item['reindex'] != Reindex::NEW_ITEM){
            return false;
        }
        
        if(!isset($data->images) || empty($data->images)){
           return false;
        }
        
        $copiedFiles = $this->prepare($item['id'], $data->images);
        $this->stack = array_merge($this->stack, $copiedFiles);
        return true;
    }
    
    /**
     * 
     * @param int $itemId
     * @param array $images
     * @return array | bool
     */
    private function prepare($itemId, $images){
        $files = [];
        foreach($images as $field => $items){
            foreach($items as  $image){
                
                if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                    continue;
                }
                
                $files[]['data'] = json_encode( [
                        'entity_id' => $itemId,
                        'field' => $field,
                        'model' => $this->modelName,
                        'path' => $this->itemsFileDirectory,
                        'name' => '',
                        'size' => 0,
                        'mimetype' => '',
                        'delta' => 0,
                        'url' => $image
                    ]);
            }            
        }
        return $files;
    }
    
    
    public  function copy(ImportImage $data){
        $data = json_decode($data->data);
        print_r($data); exit('s');
    }
}
