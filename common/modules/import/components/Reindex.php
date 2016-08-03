<?php

namespace common\modules\import\components;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\import\helpers\ImportHelper;
use frontend\modules\catalog\helpers\CatalogHelper;
use common\models\Alias;
use common\modules\import\models\Validate;



/**
*
 */
class Reindex extends \yii\base\Model
{
    const MAX_REINDEX_ITEMS = 1;
    
    const NEW_ITEM = 1;
    const REINDEX = 2;
    const INPROGRESS = 3;
    const DONE = 4;
    
    private $_model;
    private $_indexers = [];


    public function run(){   
        $model = $this->_model; 
        if(!method_exists ( $model , 'getReindexItems' )){
               return false; 
        }

        $items = $model->getReindexItems([Reindex::NEW_ITEM, Reindex::REINDEX]);
        $itemIds = array_column($items, 'id');
      //  $model->setReindexStatus(self::INPROGRESS, $itemIds);
        
        foreach($items as $item){ 
           if($item['crc32'] == $item['old_crc32']){
               continue;
           }
           
           foreach($this->_indexers as $index => $indexer){
               $this->_indexers[$index]->add($item);
           }
        }
        
        $this->flush();
      //  $model->setReindexStatus(self::DONE, $itemIds);
        
    }


    private function flush(){
        foreach($this->_indexers as $indexer){
               $indexer->flush();
        }
    }


    public function setModel($model){
        $this->_model = $model;
    }
    
    public function addIndexer($indexer){
        $this->_indexers[] = $indexer;
    }

}
