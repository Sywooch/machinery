<?php

namespace backend\widgets\AdminMenu;

use Yii;
use yii\base\Object;
use yii\web\Application;

class Url extends Object{
    
    private $_url;
    private $_query;
    
    private $_module;
    private $_controller;
    private $_action;

    public function setUrl($url) {
        
        $this->_url = parse_url($url, PHP_URL_PATH);
        $this->_query = parse_url($url, PHP_URL_QUERY);
        
        $chanks = array_filter(explode('/', trim($this->_url,'/')));
            
        if(Yii::$app->controller->module instanceof Application){
            list($this->_controller, $this->_action) = array_pad($chanks, 2, '');
        }else{
            list($this->_module, $this->_controller, $this->_action) = array_pad($chanks, 3, '');
        }
    }
    
    public function getUrl(){
        return $this->_url . ($this->_query ? '?'.$this->_query : '');
    }

    public function getIsParentActive($urls = []){
        
        if(!is_array($urls)){
            $urls = [$urls];
        }
        
        foreach($urls as $url){
            
            $this->url = $url;
            
            if($this->isActive){ 
               return true; 
            }

            if(Yii::$app->controller->module->id == $this->_module){
              //  return true; TODO
            }
        }
        
        return false;
    }


    public function getIsActive(){

     //   if(Yii::$app->requestedRoute == 'agent/update'){print_r($this->_module); echo ' ';}
        
        if (!Yii::$app->requestedRoute && $this->_url == '/'){
            return true;
        }
        
        if (Yii::$app->requestedRoute == trim($this->_url,'/')){
            return true;
        }
        
        if(Yii::$app->controller->id == $this->_controller){
            return true;
        }
        
        if(Yii::$app->controller->module->id == $this->_module && Yii::$app->controller->id == $this->_controller){
           return true;
        }

        return false;
    }
}

