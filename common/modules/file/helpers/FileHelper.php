<?php

namespace common\modules\file\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\file\models\File;
use common\helpers\ModelHelper;
use yii\helpers\FileHelper as BaseFileHelper;
use common\modules\file\helpers\StyleHelper;

class FileHelper {
    
    const DIRECTORY_PERMISSION  = 0775;
    const DIRECTORY_FILES = 'files';
    const AJAX_UPLOAD_URL = '/file/manage/upload';
    /**
     * 
     * @param mixed $class
     * @param string $style
     * @return string
     */
    public static function createDirectory($class){ 
        
        $path = self::getPath($class);

        if (!is_dir($path)){
            BaseFileHelper::createDirectory($path, self::DIRECTORY_PERMISSION);
        }
        return $path;
    }
    
    /**
     * 
     * @param string $token
     * @return string
     */
    public static function createTempDirectory($token, $field = ''){ 
        $path = self::getTempDirectory() . '/' . md5($token . $field);
        BaseFileHelper::createDirectory($path, self::DIRECTORY_PERMISSION);
        return $path;
    }
    
    /**
     * 
     * @param string $token
     * @return string
     */
    public static function getTempDirectory(){ 
        
        return Yii::$app->basePath . '/../' . self::DIRECTORY_FILES . '/tmp';
    }
    
    /**
     * 
     * @param File $file
     * @return string
     */
    public static function getToken(File $file){
        return md5(Yii::$app->request->cookieValidationKey . Yii::$app->request->getUserIP() . $file->size . $file->id);
    }
    
    /**
     * 
     * @param mixed $class
     * @param string $style
     * @return string
     */
    public static function getPath($class){
        return Yii::$app->basePath  . '/../' . self::getUrl($class);
    }
    
    /**
     * 
     * @param mixed $class
     * @param string $style
     * @return string
     */
    public static function getUrl($class){
        $path =  self::DIRECTORY_FILES . '/' . strtolower(ModelHelper::getModelName($class));
        return $path;
    }
    
    /**
     * 
     * @param string $name
     * @return string
     */
    public function text2url($name){
        $url = [
            time(),
            \URLify::filter ($name, 60, "", true),
        ];
        return implode('-', $url);
    }
    
    /**
     * 
     * @param array $files
     * @param object $view
     * @return []
     */
    public static function getFileInputPreviews($files){
        $initialPreview = [];
        if (empty($files)){
            return [];
        }
        
        if(!is_array($files)){
            $files = [$files];
        }
        
        foreach($files as $file){
            if (strpos($file->mimetype, "image") !== false){
                $initialPreview[] = Html::img('/' . $file->path . '/' . $file->name, ['class' => 'file-preview-image']); 
            } 
        }
        return $initialPreview;
    }
    
    /**
     * 
     * @param array $files
     * @return []
     */
    public static function getFileInputPreviewsConfig($files){
        $initialPreviewConfig = [];
        if (empty($files)){
            return [];
        } 
        
        if(!is_array($files)){
            $files = [$files];
        }
        
        foreach($files as $file){
            $url = Url::to(['/file/manage/delete', 'id' => $file->id, 'token' => self::getToken($file)]);
            $initialPreviewConfig[] = ['url' => $url, 'key' => "fileId-{$file->id}"];
        }
        return $initialPreviewConfig;
    }
    
    /**
     * 
     * @param mixed $model
     * @return array
     */
    public static function getFileFields($model){
        $fields = [];
        $rules = $model->rules();
        foreach($rules as $rule){
            if($rule[1] == 'file'){
                $fieldsTmp = [];
                if(is_array($rule[0])){
                    $fieldsTmp = $rule[0];
                }else{
                    $fieldsTmp[] = $rule[0];
                }
                
                unset($rule[0]);
                
                foreach($fieldsTmp as $field){
                    $fields[$field] = array_merge([$field], $rule);
                }
            }  
        }
        return $fields;
    }
    
    /**
     * 
     * @param object $model
     * @param string $field
     * @return []
     */
    public static function FileInputConfig($model, $field){        
        $files = $model->{$field};
        return [
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'uploadUrl' => Url::to([self::AJAX_UPLOAD_URL, 'id' => $model->id , 'field' => $field, 'token' => Yii::$app->request->getCsrfToken()]),
                'showUpload' => true,
                'showRemove' => false,
                'initialPreview' => self::getFileInputPreviews($files),
                'initialPreviewConfig' => self::getFileInputPreviewsConfig($files),
                'overwriteInitial' => false,
            ]
        ];
    }

    /**
     * 
     * @param File $file
     * @param StyleHelper $style
     * @return boolean|string
     */
    public static function createPreview(File $file, StyleHelper $style){
        if(!$file || strpos($file->mimetype, 'image') === false){
            return false;
        }
        $originPath = Yii::$app->basePath . '/../' . $file->path;
        $stylePath = $originPath . '/' . $style->getPath();
        if(!is_dir($stylePath)){
            BaseFileHelper::createDirectory($stylePath, self::DIRECTORY_PERMISSION);
        }
        $imageManager = new \Intervention\Image\ImageManager();
        $image = $imageManager->make($originPath . '/' . $file->name)->fit($style->height, $style->width);
        if($image->save($stylePath . '/' . $file->name, $style->quality)){
           return $stylePath . '/' . $file->name; 
        }
        return false;
    }
 
}
