<?php

namespace frontend\modules\catalog\components\urlManager;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\components\FilterParams;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\helpers\CatalogHelper;

class FilterManager{
    
    const TERM_ID_PREFIX = 't';
    const FILTER_INDICATOR = 'filter';
    const PRICE_PREFIX = 'cena'; 
    
    private $filter;
    private $vocabularyId;

    public function __construct() {
        $this->vocabularyId = Yii::$app->params['catalog']['vocabularyId'];
    }
    
    public function setFilter(FilterParams $filter){
        $this->filter = $filter;
    }

    /**
     * 
     * @return string
     */
    public function getUrl(){
        $link = array_merge($this->getPriceUrl(), $this->getTermsUrl());
        if(!empty($link)){
            return self::FILTER_INDICATOR . DIRECTORY_SEPARATOR . implode('_', $link);
        }
        return '';
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @return \frontend\modules\catalog\components\urlManager\FilterManager
     */
    public function pull(TaxonomyItems $term){
        
        if($this->filter->isExists($term)){
            $this->filter->clear($term);
        }else{
            $this->filter->add($term);
        }
        
        return $this;
    }

    /**
     * 
     * @return array
     */
    private function getPriceUrl(){
        if($this->filter->priceMin && $this->filter->priceMax){
            return [self::PRICE_PREFIX . '-'.implode('-',[$this->filter->priceMin, $this->filter->priceMax])];
        }
        return [];
    }
    
    /**
     * 
     * @return []
     */
    private function getTermsUrl(){
        $index = $this->filter->index;
        $data = [];
        foreach($this->filter->prefixes as $vocabularyId => $prefix){
            if($this->vocabularyId == $vocabularyId || !isset($this->filter->index[$vocabularyId])){
                continue;
            }
            if(count($this->filter->index[$vocabularyId]) > 1){
                $data[] = self::TERM_ID_PREFIX . $vocabularyId . '-' . implode('-', ArrayHelper::getColumn($this->filter->index[$vocabularyId], 'id')); 
            }else{
                $value = current($this->filter->index[$vocabularyId]);
                $data[] = $this->filter->prefixes[$value->vid] ? $this->filter->prefixes[$value->vid] . $value->transliteration : $value->transliteration; 
            }
        }
        return $data;
    }
    
    
    /**
     * 
     * @param string $pathInfo
     * @param array $prefixes
     * @return boolean || []
     */
    public function parseUrl($pathInfo){
        
        $chunks = explode('/', $pathInfo);
        
        if(count($chunks) < 3){
            return false;
        }
       
        $filterString = array_pop($chunks);
        if(array_pop($chunks) != self::FILTER_INDICATOR){
            return false;
        }
        $data = explode('_', $filterString);
        $index = [];
        $price = [
                'priceMax' => null,
                'priceMin' => null
        ];
        
        foreach($data as $item){

            if(($param = $this->isPriceParam($item)) !== false){
                $price = $param;
            }
            
            else
                
            if(($param = $this->isTermIdParam($item, $this->filter->prefixes)) !== false){
                $index = CatalogHelper::merge($index, $param);
            }
            
            else
            
            if(($param = $this->isNamedParam($item, $this->filter->prefixes)) !== false){
                $index = CatalogHelper::merge($index, $param);
            }
            
            else     
            
            if(($param = $this->isTermParam($item)) !== false){
                $index = CatalogHelper::merge($index, $param);
            }
            
            else{
                return false;
            }
        }
        
        return array_merge(['index' => $index], $price);
    }
    
    /**
     * 
     * @param type $param
     * @return boolean
     */
    private function isPriceParam($param){
        $param = explode('-', $param);
        if(count($param) < 3 || $param[0] != self::PRICE_PREFIX){
            return false;
        }
        return [
            'priceMin' => $param[1],
            'priceMax' => $param[2]
        ];
    }


    /**
     * 
     * @param string $transliteration
     * @return boolean || []
     */
    private function isTermParam($transliteration){
        $term = TaxonomyItems::find()->where(['transliteration' => $transliteration])->one();
        if(!$term){
            return false;
        }
        return [$term->vid => $term];
    }

    /**
     * 
     * @param string $param
     * @param array $prefixes
     * @return boolean || []
     */
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
        
        return [$vocabularyId => TaxonomyItems::findAll($param)];
    }
    
    /**
     * 
     * @param string $param
     * @param array $prefixes
     * @return boolean || []
     */
    private function isNamedParam($param, array $prefixes){

        foreach($prefixes as $vocabularyId => $prefix){
            
            if(!$prefix){
                continue;
            }
            
            if(strpos($param, $prefix) === 0 && strlen($prefix) < strlen($param)){
                $transliteration =  substr($param, strlen($prefix));
                $term = TaxonomyItems::find()->where([
                    'transliteration' => $transliteration,
                    'vid' => $vocabularyId
                        ])->one();
                if(!$term){
                    return false;
                }
                return [$term->vid => $term];
            }
        }
        return false;
    }
    
}