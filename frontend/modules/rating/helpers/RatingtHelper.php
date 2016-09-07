<?php

namespace frontend\modules\rating\helpers;
use frontend\modules\rating\components\RatingValidator;


class RatingtHelper {
    
    /**
     * 
     * @param mixed $model
     * @return array
     */
    public static function getRatingFields($model){ 
        $fields = [];
        $rules = $model->rules();
        foreach($rules as $rule){
            if($rule[1] == RatingValidator::class){
                $fieldsTmp = [];
                if(is_array($rule[0])){
                    $fieldsTmp = $rule[0];
                }else{
                    $fieldsTmp[] = $rule[0];
                }
                
                unset($rule[0]);
                
                foreach($fieldsTmp as $field){
                    $fields[$field] = array_merge([$field], $rule);
                }
            }  
        }
        return $fields;
    }
    
}