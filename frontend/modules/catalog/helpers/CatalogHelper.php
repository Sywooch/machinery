<?php

namespace frontend\modules\catalog\helpers;

use Yii;
use yii\base\InvalidParamException;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\components\Url;

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
    
    
     public static function link(array $items){
        $return = [];
        foreach($items as $item){
            $return[] = $item['transliteration'];
        }
        return implode('/', $return);
    }
    
    public static function filterLink(TaxonomyItems $term){
        $terms = Yii::$app->url->filterTerms; 

        if(isset($terms[$term->id])){
            unset($terms[$term->id]);
        }else{
            $terms[$term->id] = $term;
        }        
        
        $prepare = [];
        foreach($terms as $term){
            $prepare[$term->vid][] = $term->id;
        }
        $return = [];
        foreach($prepare as $vid => $ids){
            $return[] = Url::TERM_INDICATOR . $vid . '-' . implode('-', $ids);
        }
        
        if(empty($return)){
           return Yii::$app->url->catalogPath; 
        }
        
        return Yii::$app->url->catalogPath . DIRECTORY_SEPARATOR . Url::FILTER_INDICATOR . DIRECTORY_SEPARATOR . implode('_', $return);
    }
    
}