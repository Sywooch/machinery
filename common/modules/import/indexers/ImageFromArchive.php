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

class ImageFromArchive implements IndexerInterface{

    private $stack = [];
    private $modelName;
    private $resources = [];
    private $source;
    private $itemsFilePath;
    private $itemsFileDirectory;
    private $archiveFileDirectory;
    private $finfo;
    private $insert;


    public function __construct($model, ZipArchive $zip, Insert $insert) {
        $this->modelName = ModelHelper::getModelName($model);
        $this->itemsFilePath = Yii::getAlias('@app').'/../files/'.  strtolower($this->modelName);
        $this->itemsFileDirectory = 'files/'.  strtolower($this->modelName);
        $this->archiveFileDirectory = Yii::getAlias('@app').'/../files/import/'; 
        $this->source = $zip;
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
        
        $copiedFiles = $this->copy($item['id'], $item['source_id'],  $data->images);
        $this->stack = array_merge($this->stack, $copiedFiles);
        return true;
    }
    
    /**
     * 
     * @param int $itemId
     * @param int $source_id
     * @param array $images
     * @return array | bool
     */
    private function copy($itemId, $source_id, $images){
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
            $newFileName = $file['entity_id'] . '_' . $file['name'];
            
            if(!isset($this->resources[$source_id])){
                $this->resources[$source_id] =  $this->source;       
                if($this->resources[$source_id]->open($this->archiveFileDirectory . '/' . 'source_' . $source_id . '.zip' ) !== true){
                    $this->resources[$source_id] = false;
                }      
            }
            if($this->resources[$source_id] === false){
                continue;
            }
            
            $size = memory_get_usage(); 
            $fp = $this->resources[$source_id]->getFromName($file['name']);
            if ( ! $fp ){
                continue;
            } 
            $file['size'] = memory_get_usage() - $size;
            $file['name'] = $newFileName;
            $file['mimetype'] = $this->finfo->buffer($fp);
            $ofp = fopen( $this->itemsFilePath . '/' . $newFileName, 'w' ); 
            fwrite( $ofp, $fp );  
            fclose($ofp); 
            $copiedFiles[] = $file;
        }
        
        foreach ($copiedFiles as $index => $file){
            $copiedFiles[$index]['delta'] = $index;
        }
        
        return $copiedFiles;
    }
    

}
