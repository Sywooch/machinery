<?php
namespace common\modules\file\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\file\helpers\FileHelper;
use common\modules\file\Uploader;
use common\modules\file\Finder;

class FileBehavior extends Behavior
{
    private $_fileFields;

    /**
    * @inheritdoc
    */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterInit() {
        $this->_fileFields =  FileHelper::getFileFields($this->owner);
    }
    
    /**
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true ){
        if(isset($this->_fileFields[$name])){
            if(!isset($this->$name)){
                $this->$name = Finder::getInstances($this->owner, $name);
            }
            return true;
        }
        parent::canGetProperty($name, $checkVars);
    }
    
    /**
     * @inheritdoc
     */
    public function canSetProperty($name, $checkVars = true) {
        if(isset($this->_fileFields[$name])){
            return true;
        }
        parent::canSetProperty($name, $checkVars);
    }
   
    /**
     * @inheritdoc
     */
    public function __set($name, $value){
        if(isset($this->_fileFields[$name])){
            $this->$name = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave(){
        Uploader::save($this->owner);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete(){
        foreach($this->_fileFields as $rules){
            $field = current($rules);
            foreach($this->owner->{$field} as $instance){
                $instance->delete();
            }
        }
    }     
}

?>