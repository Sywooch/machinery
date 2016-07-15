<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\base\Object;

class FilterParams extends Object {

    const TERM_ID_PREFIX = 't';
    
    private $_filter = false;
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
    
    public function getFilter(){
        return $this->_filter;
    }
    
    public function setFilter($filter){
       $this->_filter = $filter;
    }
    
    public function getPrefixes(){
        return $this->_prefixes;
    }
    
    public function setPrefixes(array $prefixes){
       $this->_prefixes = $prefixes;
    }


}
