<?php

namespace common\helpers;

use Yii;

class ModelHelper {
    
    /**
     * 
     * @param mixed $class
     * @return string
     */
    public static function getModelName($class){
       if(is_object($class)){
           $class = get_class($class);
       }
       return substr($class, strrpos($class, '\\') + strlen('\\'));
    }
    
    /**
     * 
     * @param string $name
     * @return boolean|string
     */
    public function getModelByName($name){
        foreach(Yii::$app->params['catalog']['models'] as $model){
            if(false !== strrpos($model, $name)){
                return $model;
            }
        }
        return false;
    }

}
