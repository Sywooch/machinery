<?php
namespace frontend\modules\catalog\helpers;

use Yii;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;


class UrlHelper {
    
    const TERM_ID_PREFIX = 't';
    
    public function getUrlParams(TaxonomyItems $term, array $filter, array $prefixes){

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
        return '';
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
    
    public function parseUrlParams($pathInfo, array $prefixes){

        $chunks = explode('/', $pathInfo);
        
        if(count($chunks) <= 2){
            return false;
        }
        
        $filterString = array_pop($chunks);
        
        $data = explode('_', $filterString);
    
        $params = [];
        foreach($data as $item){

            if(($param = $this->isTermIdParam($item, $prefixes)) !== false){
                $params = $this->merge($params, $param);
            }
  
            else
            
            if(($param = $this->isNamedParam($item, $prefixes)) !== false){
                $params = $this->merge($params, $param);
            }
            
            else     
            
            if(($param = $this->isTermParam($item)) !== false){
                $params = $this->merge($params, $param);
            }
            
            else{
                return false;
            }

        }

        $pathInfo = str_replace($filterString, '', $pathInfo);

        if(($param = $this->isCatalogUrl($pathInfo)) === false){
            return false;
        }

        $params = $this->merge($params, $param);
        
        return $params;
         
    }
    
    public function isCatalogUrl($pathInfo){

        if($pathInfo == ''){
            return false;
        }
        
        $params = array_filter(explode('/', $pathInfo));

        if(empty($params)){
            return false;
        }

        $terms = TaxonomyItems::find()
        ->where([
           'vid' => Yii::$app->params['catalog']['vocabularyId'],
           'transliteration' => $params 
        ])        
        ->orderBy([
                'weight' => SORT_ASC
        ])
        ->all();
        
        if(!$terms || count($terms) != count($params)){
            return false;
        }
        $term = array_pop($terms);
        return [$term->vid => $term->id];
    }


    private function merge($params, $param){
        foreach($param as $key => $value){
            $params[$key] = $value;
        }
        return $params;
    }


    private function isTermParam($transliteration){
        $term = TaxonomyItems::find()->where(['transliteration' => $transliteration])->one();
        if(!$term){
            return false;
        }
        return [$term->vid => $term->id];
    }

    private function isTermIdParam($param, array $prefixes){
        $param = explode('-', $param);
        if(count($param) < 2){
            return false;
        }
        
        $prefix = array_shift($param);
        $vocabularyId = substr($prefix, 1);

        if(strpos($prefix, self::TERM_ID_PREFIX) !== 0 || !isset($prefixes[$vocabularyId]) ){
             return false;
        }

        foreach ($param as $termId) {
            if (!is_numeric($termId)) {
                return false;
            }
        }
        return [$vocabularyId => $param];
    }
    
    private function isNamedParam($param, array $prefixes){

        foreach($prefixes as $vocabularyId => $prefix){
            
            if(!$prefix){
                continue;
            }
            
            if(strpos($param, $prefix) === 0 && strlen($prefix) < strlen($param)){
                $transliteration =  substr($param, strlen($prefix));
                $term = TaxonomyItems::find()->where(['transliteration' => $transliteration])->one();
                if(!$term){
                    return false;
                }
                return [$term->vid => $term->id];
            }
        }
        return false;
    }
    
}
