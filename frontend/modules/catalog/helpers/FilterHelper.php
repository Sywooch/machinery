<?php

namespace frontend\modules\catalog\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\components\FilterParams;

class FilterHelper {

    const TERM_ID_PREFIX = 't';
    const FILTER_INDICATOR = 'filter';
    const PRICE_PREFIX = 'cena'; 
    
    public static function isActive(FilterParams $filter, TaxonomyItems $term){
        if(isset($filter->index[$term->vid][$term->id])){
            return true;
        }
        return false;
    }

    /**
     * 
     * @param FilterParams $filter
     * @return string
     */
    public static function getFilterString(FilterParams $filter){
        $link = [];
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
        $index = $filter->index;
        foreach($filter->prefixes as $vocabularyId => $prefix){
            if($catalogVocabularyId == $vocabularyId || !isset($index[$vocabularyId])){
                continue;
            }
            $value = $index[$vocabularyId];
            if(count($value) > 1){
                $link[] = self::TERM_ID_PREFIX . $vocabularyId . '-' . implode('-', ArrayHelper::getColumn($value, 'id')); 
            }else{
                $value = array_shift($value);
                $link[] = $filter->prefixes[$value->vid] ? $filter->prefixes[$value->vid] . $value->transliteration : $value->transliteration; 
            }
        }
        if($filter->priceMin && $filter->priceMax){
            $link[] = self::PRICE_PREFIX . '-'.implode('-',[$filter->priceMin, $filter->priceMax]);
        }
        
        if(!empty($link)){
            return self::FILTER_INDICATOR . DIRECTORY_SEPARATOR . implode('_', $link);
        }
        
        return '';
    }

    /**
     * 
     * @param FilterParams $filter
     * @param TaxonomyItems $term
     * @return FilterParams
     */
    public static function addIndex(FilterParams $filter, TaxonomyItems $term){

        $finded = false;
        $index = $filter->index;
        
        if(!empty($index)){
            foreach($index as $vocabularyId => $value){
                if($vocabularyId != $term->vid){
                    continue;
                }
                $finded = true;
                if(is_array($value)){
                    $index[$vocabularyId][$term->id] = $term;
                }elseif($value instanceof TaxonomyItems){
                    $index[$vocabularyId] = [$value, $term];
                }
            }
        }

        if(!$finded){
            $index[$term->vid][$term->id] = $term;
        }
        
        $filter->index = $index;
        return $filter;
    }
    
    /**
     * 
     * @param FilterParams $filter
     * @param TaxonomyItems $term
     * @return boolean 
     */
    public static function clearIndex(FilterParams $filter, TaxonomyItems $term){
        $index = $filter->index;
        if(empty($index)){
            return false;
        }
        foreach($index as $vocabularyId => $terms){
            foreach($terms as $termId => $item){
                if($item->id == $term->id){
                   unset($index[$vocabularyId][$termId]);
                   if(empty($index[$vocabularyId])){
                       unset($index[$vocabularyId]);
                   }
                   $filter->index = $index;
                   return true;
                }
            }
        }
        return false;
    }
    
    /**
     * 
     * @param FilterParams $filter
     * @param array $transliterations
     * @return boolean|FilterParams
     */
    public static function clearIndexByTransliteration(FilterParams $filter, array $transliterations){
        $index = $filter->index;
        if(empty($index)){
            return false;
        }
        
        foreach($index as $vocabularyId => $terms){
            foreach($terms as $term){
                if(in_array($term->transliteration, $transliterations)){
                    unset($index[$vocabularyId][$term->id]);
                    if(empty($index[$vocabularyId])){
                        unset($index[$vocabularyId]);
                    }
                }
            }
        }
        
        $filter->index = $index;
        return $filter;
    }
    
}