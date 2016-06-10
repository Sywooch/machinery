<?php

namespace common\modules\file\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\helpers\ModelHelper;
use common\modules\file\models\File;
use common\modules\file\helpers\FileHelper;
use yii\helpers\FileHelper as BaseFileHelper;

class FileBehavior extends Behavior
{
    public function __set($name, $value){
        $this->$name = $value;
    }
    
    /**
    * @inheritdoc
    */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }
    
    public function afterInit() {
       $fileFields =  FileHelper::getFileFields($this->owner);
       foreach($fileFields as $field => $rule){
            $this->$field = $this->getFiles($field);
       }
    }
   
    public function afterDelete(){
        $fields = FileHelper::getFileFields($this->owner);
        foreach ($fields as $fieldName => $field){
            $files = $this->owner->{$fieldName};
            foreach ($files as $file){
               $path = \Yii::$app->basePath . '/../' . $file->path . '/' . $file->name;
               if(is_file($path)){
                   unlink($path);
               }
               $file->delete();
            }
        }
    }
    /**
     * @inheritdoc
     */
    public function afterInsert($event){
        
        $token = \Yii::$app->request->post('_csrf');
        
        $fields = FileHelper::getFileFields($this->owner);

        foreach ($fields as $fieldName => $field){
            $path = FileHelper::getTempDirectory() . '/' . md5($token . $fieldName); 
            if(!is_dir($path)){
                continue;
            }

            $files = BaseFileHelper::findFiles($path);
            foreach($files as $file){
                $fileName = basename($file);
                copy ( $file , FileHelper::getPath($this->owner). '/' . $fileName );
                $fileModel = \Yii::createObject([
                            'class' => File::class,
                            'entity_id' => $this->owner->id,
                            'field' => $fieldName,
                            'model' => FileHelper::getModelName($this->owner),
                            'name' => $fileName,
                            'path' => FileHelper::getUrl($this->owner),
                            'mimetype' => BaseFileHelper::getMimeType($file),
                            'size' => filesize($file)
                         ]);
                $fileModel->save();
            }
            BaseFileHelper::removeDirectory($path);
        }
    }
    
    /**
     * 
     * @param string $field
     * @return object
     */
    protected function getFiles($field = ''){
         return $this->owner->hasMany(File::className(), ['entity_id' => 'id'])
                 ->where(['model'=>  ModelHelper::getModelName($this->owner)])
                 ->andFilterWhere(['field' => $field])
                 ->orderBy([
                     'delta' => SORT_ASC
                 ]);
    }
}

?>