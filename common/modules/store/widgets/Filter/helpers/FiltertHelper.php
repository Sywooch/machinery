<?php

namespace common\modules\store\widgets\Filter\helpers;

use Yii;
use yii\helpers\Url;
use common\modules\store\components\StoreUrlRule;
use common\modules\taxonomy\models\TaxonomyItems;

class FiltertHelper {
    
    /**
     * 
     * @param TaxonomyItems $term
     * @return string
     */
    public static function link(StoreUrlRule $url, TaxonomyItems $term){
        $terms = $url->filterTerms; 

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
            $return[] = StoreUrlRule::TERM_INDICATOR . $vid . '-' . implode('-', $ids);
        }
        
        if(empty($return)){
           return $url->catalogPath; 
        }
        
        return $url->catalogPath . DIRECTORY_SEPARATOR . StoreUrlRule::FILTER_INDICATOR . DIRECTORY_SEPARATOR . implode('_', $return);
    }
    
    
}