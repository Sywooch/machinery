<?php
namespace frontend\modules\catalog\helpers;

use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;


class UrlHelper {
    
    public function getUrlParams(TaxonomyVocabulary $vocabulary, TaxonomyItems $term){
        
        $link = '';
        $data = [];
        $data[] = $vocabulary->prefix ? $term->transliteration : $term->id;
        
        if($vocabulary->prefix == ''){
            $link = 't' . '_' . implode('_', $data );
        }elseif($vocabulary->prefix == '(none)'){
           $link = implode('', $data );
        }else{
            $link = $vocabulary->prefix . '-' . implode('_', $data );
        }
        
        return $link;
        
    }
    
}
