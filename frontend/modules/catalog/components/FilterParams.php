<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\base\Object;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;
use common\modules\taxonomy\models\TaxonomyItems;

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
            self::$_instance->_prefixes = TaxonomyVocabularySearch::getPrefixes(Yii::$app->params['catalog']['filterVocabularyIds']);
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
    
    public function clear(TaxonomyItems $term){
        foreach($this->_index as $id => $terms){
            if(isset($terms[$term->id])){
                unset($this->_index[$id][$term->id]);
                if(empty($this->_index[$id])){
                    unset($this->_index[$id]);
                }
                return true;
            }
        }
        return false;
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     */
    public function add(TaxonomyItems $term){
        if(!isset($this->_index[$term->vid])){
            $this->_index[$term->vid] = [];
        }
        $this->_index[$term->vid][$term->id] = $term;
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @return boolean
     */
    public function isExists(TaxonomyItems $term){
        foreach($this->_index as $terms){
            if(isset($terms[$term->id])){
                return true;
            }
        }
        return false;
    }


}
