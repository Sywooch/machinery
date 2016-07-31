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
     * @param int $id
     * @return string
     */
    public function getModelByTermId($id){

        if(isset(\Yii::$app->params['catalog']['models'][$id])){
            return \Yii::$app->params['catalog']['models'][$id];
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
     * @param TaxonomyItems $taxonomyItem
     * @param int $childId
     * @param array $breadcrumb
     * @return array
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
    public static function addId(TaxonomyItems $term, &$index){

        $finded = false;
        
        if(!empty($index)){
            foreach($index as $vocabularyId => $value){
                if($vocabularyId != $term->vid){
                    continue;
                }
                $finded = true;
                if(is_array($value)){
                    $index[$vocabularyId][] = $term;
                }elseif($value instanceof TaxonomyItems){
                    $index[$vocabularyId] = [$value, $term];
                }
            }
        }

        if(!$finded){
            $index[$term->vid] = $term;
        }
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @param array $filter
     * @return boolean
     */
    public static function clearId(TaxonomyItems $term, &$index = []){
        if(empty($index)){
            return false;
        }
        foreach($index as $id => $value){
            if(is_array($value)){
               return self::clearId($term, $index[$id]);
            }elseif($value instanceof TaxonomyItems && $value->id == $term->id){
                unset($index[$id]);
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