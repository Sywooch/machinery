<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\base\Object;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;

class FilterParams extends Object {

    const TERM_ID_PREFIX = 't';
    
    private $_index = false;
    private $_priceMin = null;
    private $_priceMax = null;
    private $_prefixes = null;
    private $_catalogUrl = null;
    
    private static $_instance = null;
        
    public static function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    public function getCatalogUrl(){
        return $this->_catalogUrl;
    }
    
    public function setCatalogUrl($catalogUrl){
        $this->_catalogUrl = preg_replace("#/$#", "", $catalogUrl);
    }
    
    
    public function getPriceMin(){
        return $this->_priceMin;
    }
    
    public function setPriceMin($priceMin){
       $this->_priceMin = (float)$priceMin;
    }
    
    public function getPriceMax(){
        return $this->_priceMax;
    }
    
    public function setPriceMax($priceMax){
       $this->_priceMax = (float)$priceMax;
    }
    
    public function getIndex(){
        return $this->_index;
    }
    
    public function setIndex($index){
       $this->_index = $index;
    }
    
    public function getPrefixes(){
        return $this->_prefixes;
    }
    
    public function setPrefixes(array $prefixes){
       $this->_prefixes = $prefixes;
    }


}
