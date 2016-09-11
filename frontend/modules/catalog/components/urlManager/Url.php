<?php
namespace frontend\modules\catalog\components\urlManager;

use frontend\modules\catalog\components\FilterParams;

class Url{
    
    private $managers = [];
    private $filterInstance;

    public function __construct() {
        $this->filterInstance = FilterParams::getInstance();
    }
    
    public function __get($name){
        if(!isset($this->managers[$name])){
            $name = ucfirst($name);
            $nameSpace = "\\frontend\modules\catalog\components\urlManager\\{$name}Manager";
            $manager = new $nameSpace();
            $manager->setFilter($this->filterInstance);
            $this->managers[$name] = $manager;
        }
        return $this->managers[$name];
    }
    
    public function setFilterInstance(FilterParams $filterInstance){
        $this->filterInstance = $filterInstance;
    }
    
    public function parseUrl($pathInfo){
        if($this->filterInstance->index !== false)
        {
            return $this->filterInstance->index;
        }
        
        $paramsCatalog = $this->catalog->parseUrl($pathInfo);
        
        if($paramsCatalog === false){
            return false;
        }
        
        foreach($paramsCatalog as $vocabularyId => $terms){
            foreach($terms as $term){
                $this->filterInstance->add($term);
            }
        }
        
        ;
 
        if(($paramsFilter = $this->filter->parseUrl($pathInfo)) !== false){
            foreach($paramsFilter['index'] as $terms){
                if(is_array($terms)){
                    foreach($terms as $term){
                        $this->filterInstance->add($term); 
                    }
                }else{
                   $this->filterInstance->add($terms); 
                } 
            }
            $this->filterInstance->priceMin = $paramsFilter['priceMin'];
            $this->filterInstance->priceMax = $paramsFilter['priceMax'];
        }
        return $this->filterInstance;
    }
    
}