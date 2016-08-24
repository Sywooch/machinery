<?php

namespace frontend\modules\catalog\helpers;

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
    
    /**
     * 
     * @param object $model
     * @return int
     */
    public function getCatalogIdByModel($model){
        return array_search(get_class($model), \Yii::$app->params['catalog']['models']);
    }
 
    /**
     * 
     * @param array $params
     * @param array $param
     * @return array
     */
    public static function merge(array $params, array $param){
        foreach($param as $key => $value){
            $params[$key] = $value;
        }
        return $params;
    }


    /**
     * @param array $items
     * @param int $vocabularyId
     * @return array
     */
    public static function getItemByVocabularyIdOne(array $items, $vocabularyId){
        foreach($items as $item){
            if($item['vid'] == $vocabularyId){
                return $item;
            }
        }
        return [];
    }
}