<?php

namespace common\helpers;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;

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
    
    public static function getModelClass($name){
        $model = '\\backend\\models\\' . $name;
        return $model::className();
    }

    public static function getFields($model){
        return [];
    }
    
    /**
     * 
     * @param TaxonomyItems $taxonomyItem
     * @return object
     * @throws InvalidParamException
     */
    public static function getModelByTerm(TaxonomyItems $taxonomyItem){
        $modelIndex = \Yii::$app->params['catalog']['models'];

        if(isset($modelIndex[$taxonomyItem->id])){
            return new $modelIndex[$taxonomyItem->id];
        }elseif(isset($modelIndex[$taxonomyItem->pid])){
            return new $modelIndex[$taxonomyItem->pid];
        }else{
            throw new InvalidParamException(\Yii::t('yii', 'Model not fount.'));
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function getModelByTermId($id){

        if(isset(\Yii::$app->params['catalog']['models'][$id])){
            return new \Yii::$app->params['catalog']['models'][$id];
        }
        return false;
    }

    /**
     * 
     * @param string $name
     * @return boolean|string
     */
    public function getModelByName($name){
        foreach(\Yii::$app->params['catalog']['models'] as $model){
            if(false !== strrpos($model, $name)){
                return new $model();
            }
        }
        return false;
    }
    
}
