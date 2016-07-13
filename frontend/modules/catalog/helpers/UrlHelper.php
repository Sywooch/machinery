<?php
namespace frontend\modules\catalog\helpers;

use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;


class UrlHelper {
    
    const TERM_ID_PREFIX = 't0';
    
    public function getUrlParams(TaxonomyVocabulary $vocabulary, TaxonomyItems $term){
        
        $link = '';
        $data = [];
        $data[] = $vocabulary->prefix ? $term->transliteration : $term->id;
        
        if($vocabulary->prefix == ''){
            $link = self::TERM_ID_PREFIX . '-' . implode('_', $data );
        }elseif($vocabulary->prefix == '(none)'){
           $link = implode('', $data );
        }else{
            $link = $vocabulary->prefix . '-' . implode('_', $data );
        }
        
        return $link;
        
    }
    
    public function parseUrlParams(array $chunks, array $prefixes){

        if(count($chunks) <= 2){
            return false;
        }
        $data = explode('_', array_pop($chunks));
    
        $params = [];
        foreach($data as $item){

            if(($param = $this->isNamedParam($item, $prefixes)) !== false){
                $params = array_merge($params, $param);
            }
            
            else
            
            if(($param = $this->isTermIdParam($item, $prefixes)) !== false){
                $params = array_merge($params, [$param]);
            }
  
            else
            
            if(($param = $this->isTermParam($item)) !== false){
                $params = array_merge($params, [$param->id]);
            }
            
            else{
                return false;
            }

        }
        return $params;
         
    }
    
    private function isTermParam($transliteration){
        $term = TaxonomyItems::find()->where(['transliteration' => $transliteration])->one();
        if(!$term){
            return false;
        }
        return $term;
    }

    private function isTermIdParam($param){
        $param = explode('-', $param);
        if(count($param) < 2){
            return false;
        }
        
        if($param[0] != self::TERM_ID_PREFIX){
            return false;
        }
        unset($param[0]);
       
        foreach ($param as $termId) {
            if (!is_numeric($termId)) {
                return false;
            }
        }
        return $param;
    }
    private function isNamedParam($param, array $prefixes){
        $param = explode('-', $param);
        
        if(count($param) < 2){
            return false;
        }
        
        if(!key_exists($param[0], $prefixes)){
            return false;
        }

        unset($param[0]);
        return $param;
    }
    
}
