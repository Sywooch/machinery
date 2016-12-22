<?php
namespace common\modules\file;

use Yii;
use common\modules\file\InvalidStorageException;
use common\modules\file\filestorage\Storage;

class Module extends \yii\base\Module
{
    public $storages;
    public $storage;
    
    public function init()
    {
        $this->createStorages();
        parent::init();
    }

    private function createStorages(){
        $storages = [];
        foreach($this->storages as $name => $config){
            $class = array_shift($config);
            $storage = new $class($config);
            if(!($storage instanceof Storage)){
                throw new InvalidStorageException();
            }
            $storages[] = $storage; 
        }
        $this->storages = $storages;
        $this->storage = Yii::$container->get($this->storage);
    }
}
