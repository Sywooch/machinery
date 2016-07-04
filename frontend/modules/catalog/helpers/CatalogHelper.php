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
    
    public static function types(){
        return [
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT
        ];
    }
    public static function fields(){
        return [
                   'sku',
                   'price',
                   'title',
                   'description',
                   'reindex',
                   'user_id',
                   'source_id'
               ];
    }   
}