<?php
namespace common\modules\file\filestorage;

use yii\db\ActiveRecordInterface;
use common\modules\file\filestorage\StorageInterface;
use yii\web\UploadedFile;
use yii\base\Object;

abstract class Storage extends Object implements StorageInterface{
    
    protected $_entity;
    protected $_field;
    protected $_instance;

    public function __construct(array $config = []){
        foreach($config as $key => $value){
            $this->{$key} = $value;
        }
    }
    
    /**
     * 
     * @return ActiveRecordInterface
     */
    public function getEntity() {
        return $this->_entity;
    }

    /**
     * 
     * @param ActiveRecordInterface $entity
     */
    public function setEntity(ActiveRecordInterface $entity) {
        $this->_entity = $entity;
    }
    
    /**
     * 
     * @return UploadedFile
     */
    public function getInstance() {
        return $this->_instance;
    }
    
    /**
     * 
     * @param UploadedFile $instance
     */
    public function setInstance(UploadedFile $instance) {
        $this->_instance = $instance;
    }
    
    /**
     * 
     * @return string
     */
    public function getField(){
        return $this->_field;
    }
    
    /**
     * 
     * @param string $field
     */
    public function setField(string $field){
        $this->_field = $field;
    }
        
}

