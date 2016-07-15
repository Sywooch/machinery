<?php

namespace frontend\modules\catalog\helpers;

use common\modules\taxonomy\models\TaxonomyItems;

class UrlHelper {

    public function getUrl(TaxonomyItems $term, array $filter, array $prefixes){

        $data = [];

        if(isset($filter[$term->vid])){
            $data = $filter[$term->vid];
            if(!is_array($data)){
                $data = [$data];
            }
            $data[] = $term->id;
            $data = array_unique($data);
            $filter[$term->vid] = $data;
           
        }else{
            $filter[$term->vid] = $term->id;
        }
        

        print_r($filter); exit('zz+A+A++Az');
        
        $link = '';
        $data = [];
        $data[] = $vocabulary->prefix ? $term->transliteration : $term->id;
        
        if($vocabulary->prefix == ''){
            $link = self::TERM_ID_PREFIX . '-' . implode('_', $data );
        }elseif($vocabulary->prefix == '(none)'){
           $link = implode('', $data );
        }else{
            $link = $vocabulary->prefix . '' . implode('_', $data );
        }
        
        return $link;
        
    }
    
}