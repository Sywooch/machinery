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
    
}
