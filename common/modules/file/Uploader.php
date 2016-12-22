<?php
namespace common\modules\file;

use Yii;
use yii\web\UploadedFile;
use common\modules\file\helpers\FileHelper;
use yii\db\ActiveRecordInterface;

class Uploader{

    /**
     * 
     * @param ActiveRecordInterface $entity
     * @return \self
     */
    public static function getInstances(ActiveRecordInterface &$entity){
        $upload = new self();
        $fields = FileHelper::getFileFields($entity);
        foreach($fields as $rule){
            $field = $rule[0];
            $entity->{$field} = UploadedFile::getInstances($entity, $field);
        }
    }
    
    /**
     * 
     * @param ActiveRecordInterface $entity
     */
    public static function save(ActiveRecordInterface $entity){
        $module = Yii::$app->getModule('file');
        $fields = FileHelper::getFileFields($entity);
        
        foreach($fields as $rule){
            $field = $rule[0];
            foreach($entity->{$field} as $instance){
                if($instance instanceof UploadedFile){
                    foreach($module->storages as $storage){
                        $storage->setEntity($entity);
                        $storage->setInstance($instance);
                        $storage->setField($field);
                        if($storage->save()){
                            $module->storage->save($storage);
                        }
                    }
                }
            }   
        }
    }
    
}
