<?php
namespace common\modules\import\indexers;

use Yii;
use common\modules\import\IndexerInterface;
use ZipArchive;
use common\helpers\ModelHelper;
use finfo;
use common\modules\import\components\Insert;
use common\modules\file\models\File;
use common\modules\import\helpers\ImportHelper;
use common\modules\import\components\Reindex;
use common\modules\import\models\ImportImage;

class ImageFromUrl implements IndexerInterface{

    private $stack = [];
    private $modelName;
    private $itemsFilePath;
    private $itemsFileDirectory;
    private $archiveFileDirectory;
    private $finfo;
    private $insert;
    private $importImage;


    public function __construct($model, ImportImage $importImage, Insert $insert) {
        $this->modelName = ModelHelper::getModelName($model);
        $this->itemsFilePath = Yii::getAlias('@app').'/../files/'.  strtolower($this->modelName);
        $this->itemsFileDirectory = 'files/'.  strtolower($this->modelName);
        $this->archiveFileDirectory = Yii::getAlias('@app').'/../files/import/'; 
        $this->finfo = new finfo(FILEINFO_MIME_TYPE);
        $this->insert = $insert;
    }


    public function flush(){
        if(empty($this->stack)){
            return [];
        }
        $this->insert->insertBatch(File::TABLE_FILES, $this->stack, ImportHelper::importImagesFields(), ImportHelper::importImagesFieldTypes());
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
        
        $copiedFiles = $this->copy($item['id'], $data->images);
        $this->stack = array_merge($this->stack, $copiedFiles);
        return true;
    }
    
    /**
     * 
     * @param int $itemId
     * @param array $images
     * @return array | bool
     */
    public function copy($itemId, $images){
        $files = [];
        $copiedFiles = [];
        foreach($images as $field => $items){
            foreach($items as  $image){
                $files[] = [
                        'entity_id' => $itemId,
                        'field' => $field,
                        'model' => $this->modelName,
                        'path' => $this->itemsFileDirectory,
                        'name' => $image,
                        'size' => 0,
                        'mimetype' => '',
                        'delta' => 0
                    ];
            }            
        }
        
        foreach($files as $index => $file){
            $file['name'] = $file['entity_id'] . '_' . $file['name'];
            
            $this->importImage->data = json_encode($file);
            $this->importImage->save();
            $size = memory_get_usage(); 

            if(($fp = file_get_contents($file['url'])) && file_put_contents($this->itemsFilePath . '/' . $newFileName, $fp)){
                $file['size'] = memory_get_usage() - $size;
                $file['name'] = $newFileName;
                $file['mimetype'] = $this->finfo->buffer($fp);
                $copiedFiles[] = $file;
                unset($fp);
            }else{
                //TODO: добавить в отложеную загрузку
            }  
        }
        
        foreach ($copiedFiles as $index => $file){
            $copiedFiles[$index]['delta'] = $index;
        }
        
        return $copiedFiles;
    }
    

}
