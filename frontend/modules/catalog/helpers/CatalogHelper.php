<?php

namespace frontend\modules\catalog\helpers;

use yii\helpers\Html;
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
     * @param TaxonomyItems $taxonomyItem
     * @return []
     */
    public function getBreadcrumb(TaxonomyItems $taxonomyItem, $childId = 0,  &$breadcrumb = []){
        if($taxonomyItem->pid){
            self::getBreadcrumb($taxonomyItem->parent,$taxonomyItem->id, $breadcrumb);
        }
        if($childId){
            $breadcrumb[] = ['label' => Html::encode($taxonomyItem->name), 'url' => $taxonomyItem->transliteration];
        }else{
            $breadcrumb[] = Html::encode($taxonomyItem->name);
        }
        return $breadcrumb;
    }
    
    
    /**
     * 
     * @param TaxonomyItems $term
     * @param array $filter
     */
    public static function addId(TaxonomyItems $term, array &$filter){

        $finded = false;
        
        foreach($filter as $vocabularyId => $value){
            
            if($vocabularyId != $term->vid){
                continue;
            }
            
            $finded = true;
               
            if(is_array($value)){
                $filter[$vocabularyId][] = $term;
            }elseif($value instanceof TaxonomyItems){
                $filter[$vocabularyId] = [$value, $term];
            }
        }
        
        if(!$finded){
            $filter[$term->vid] = $term;
        }
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @param array $filter
     * @return boolean
     */
    public static function clearId(TaxonomyItems $term, array &$filter){

        foreach($filter as $id => $value){
            if(is_array($value)){
               return self::clearId($term, $filter[$id]);
            }elseif($value instanceof TaxonomyItems && $value->id == $term->id){
                unset($filter[$id]);
                return true;
            }
        }
        return false;
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
    
}