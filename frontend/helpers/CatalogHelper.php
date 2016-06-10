<?php

namespace frontend\helpers;

use yii\base\InvalidParamException;
use common\modules\taxonomy\models\TaxonomyItems;

class CatalogHelper {
    
    
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
            throw new InvalidParamException(Yii::t('yii', 'Model not fount.'));
        }
    }
    
    /**
     * 
     * @param string $name
     * @return boolean|string
     */
    public function getModelByName($name){
        foreach(\Yii::$app->params['catalog']['models'] as $model){
            if(false !== strrpos($model, $name)){
                return $model;
            }
        }
        return false;
    }
    
    
}