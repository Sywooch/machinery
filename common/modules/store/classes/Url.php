<?php

namespace common\modules\store\classes;

use yii\base\Object;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\helpers\ArrayHelper;
use common\modules\store\classes\UrlInterface;

class Url extends Object implements UrlInterface{
    
    const FILTER_INDICATOR = 'filter';
    const TERM_INDICATOR = 't';

    private $_path;
    private $_catalogPath;
    private $_filterPath;
    private $_terms;
    private $_catalogTerms = [];
    private $_catalogMainTerm;
    private $_catalogCategoryTerm;
    private $_filterTerms = [];
    private $_catalogPathValid;
    private $_filterPathValid;
    private $_priceMin;
    private $_priceMax;

    public function setPath($path){
        $this->_path = $path;
        $params = explode(self::FILTER_INDICATOR, $this->_path);
        $this->_catalogPath = trim(array_shift($params),'\/');
        $this->_filterPath = empty($params) ? null : trim(array_shift($params),'\/');
        $this->_catalogPathValid = false;
        $this->_filterPathValid = true;
        $this->_terms = [];
        $this->parse();
    }
    
    public function getFilterTerms(){
        return $this->_filterTerms;
    }
    public function getCatalogPath(){
        return $this->_catalogPath;
    }
    public function getMin(){
        return $this->_priceMin;
    }
    public function getMax(){
        return $this->_priceMax;
    }
    public function getMain(){
        return $this->_catalogMainTerm;
    }
    public function getCategory(){
        return $this->_catalogCategoryTerm;
    }
    public function validate(){
        return $this->_catalogPathValid & $this->_filterPathValid;
    }
    
    public function getTerms(array $except = []){
        if(empty($this->_terms)){
            foreach($this->_catalogTerms as $term){
               $this->_terms[$term->id] = $term;
            }
            foreach($this->_filterTerms as $term){
               $this->_terms[$term->id] = $term;
            }
        }
        $terms = $this->_terms;
        foreach($except as $term){
            if(isset($terms[$term->id])){
                unset($terms[$term->id]);
            }
        }
        return $terms;
    }
    
    public function parse(){
        if($this->_catalogPath){
            $this->parseCatalog();
        }
        if($this->_filterPath){
            $this->parseFilter();
        }
    }

    public function parseFilter(){
        $params = explode('_',$this->_filterPath);
        $terms = [];
        $termsIds = [];
        $termsTransliterations = [];
        foreach($params as $param){
            if(preg_match_all('/('.self::TERM_INDICATOR.'{1}|\-{1})([0-9]+)/', $param, $matches) && (strlen(implode('-',$matches[2]))+1) == strlen($param)){
               array_shift($matches[2]);
               $termsIds = array_merge($termsIds,$matches[2]); 
            }elseif(preg_match('/prc(\d+)-(\d+)$/', $param, $matches)){
                list($param, $this->_priceMin, $this->_priceMax) = $matches;
            }else{
                $termsTransliterations[] = $param; 
            } 
        }
        
        if(!empty($termsIds)){
            $this->_filterTerms = TaxonomyItems::findAll($termsIds);  
        }
        
        if(!empty($termsTransliterations)){
            $this->_filterTerms = array_merge($this->_filterTerms, TaxonomyItems::find()
                ->where([
                    'transliteration' => $termsTransliterations
                ])
                ->all());
        }
        
        $this->_filterTerms = ArrayHelper::index($this->_filterTerms,'id');

        $this->_filterPathValid = count($termsTransliterations) + count($termsIds) == count($this->_filterTerms);
        return $this->_filterTerms;
    }
    
    public function parseCatalog(){
        $chanks = explode('/', $this->_catalogPath);  
        $this->_catalogTerms = TaxonomyItems::find()
                ->where([
                    'transliteration' => explode('/', $this->_catalogPath)
                ])
                ->all();
        if($this->_catalogTerms){
            foreach($this->_catalogTerms as $term){
                if(!$term->pid){
                    $this->_catalogMainTerm = $term;
                }else{
                    $this->_catalogCategoryTerm = $term;
                }
            } 
        }
        
        $this->_catalogPathValid = count($chanks) == count($this->_catalogTerms);
        return $this->_catalogTerms;      
    }

}