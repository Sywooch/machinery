<?php

namespace common\modules\file\helpers;

use Yii;
use common\modules\file\models\File;
use common\modules\file\helpers\FileHelper;

class StyleHelper {
    
    const STYLE_DIR = 'style';

    private $_resolution;
    private $_fileId = false;
    public $quality = 100;
    public $height;
    public $width;
    private $isValid = false;
    public function __construct($str = '') {
        if($this->isStyleUrl($str)){
            $this->_resolution = $this->getResolution($str);
            $this->height = $this->_resolution[1];
            $this->width = $this->_resolution[2];
            $this->_fileId = $this->getIdFromUrl($str);
            $this->isValid = true;
        }elseif($this->isResolution($str)){
            $this->_resolution = $this->getResolution($str);
            $this->height = $this->_resolution[1];
            $this->width = $this->_resolution[2];
        }
        
    }
    
    /**
     * 
     * @return int
     */
    public function getFileId(){
        return $this->_fileId;
    }
    
    /**
     * 
     * @return boolean|string
     */
    public function getName(){
        if(!empty($this->_resolution)){
            return $this->_resolution[0];
        }
        return '';
    }
    
    /**
     * 
     * @param string $url
     * @return null
     */
    private function getIdFromUrl($url){
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $data);
        if(key_exists('id', $data)){
            return $data['id'];
        }
        return null;
    }
    
    /**
     * 
     * @return string
     */
    public function getPath(){
        return self::STYLE_DIR . '/' . $this->getName();
    }

    
    /**
     * 
     * @param File $file
     * @param string $style
     * @return string
     */
    public static function getPreviewUrl(File $file, $style){
        return $file->path . '/' .self::STYLE_DIR. '/'  . $style . '/' . $file->name . '?token=' . FileHelper::getToken($file) . '&id='.$file->id; 
    }
    
    /**
     * 
     * @param string $url
     * @return boolean
     */
    private function isStyleUrl($url){
        $path = parse_url($url);
        parse_str($path['query'], $params);
        if(strpos($path['path'], 'style') !== false 
                && key_exists('token', $params) 
                && key_exists('id', $params)){
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param string $resolution
     * @return boolean|array
     */
    private function isResolution($resolution){
        $data = explode('x', $resolution);
        if(count($data) != 2){
            return false;
        }
        return $data;
    }
    
    /**
     * 
     * @param string $resolution
     * @return array
     */
    private function getResolution($resolution){
        preg_match("/([0-9_]+)x([0-9_]+)/i", $resolution, $matches);
        return $matches;
    }


    /**
     * 
     * @return boolean
     */
    public function validate(){
        return $this->isValid;
    }

}
