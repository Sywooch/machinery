<?php

namespace common\modules\file\helpers;

use common\helpers\URLify;
use yii;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper as BaseFileHelper;
use common\modules\file\filestorage\InstanceInterface;
use Intervention\Image\ImageManager;

class FileHelper
{

    const DIRECTORY_PERMISSION = 0775;
    const DIRECTORY_FILES = 'files';
    const AJAX_UPLOAD_URL = '/file/manage/upload';

    public static $style;


    /**
     * @param $class
     * @return string
     * @throws \yii\base\Exception
     */
    public static function createDirectory($class)
    {

        $path = self::getPath($class);

        if (!is_dir($path)) {
            BaseFileHelper::createDirectory($path, self::DIRECTORY_PERMISSION);
        }
        return $path;
    }

    /**
     * @param $token
     * @param string $field
     * @return string
     * @throws \yii\base\Exception
     */
    public static function createTempDirectory($token, $field = '') : string
    {
        $path = self::getTempDirectory() . '/' . md5($token . $field);
        BaseFileHelper::createDirectory($path, self::DIRECTORY_PERMISSION);
        return $path;
    }

    /**
     * @return string
     */
    public static function getTempDirectory() : string
    {

        return Yii::$app->basePath . '/../' . self::DIRECTORY_FILES . '/tmp';
    }

    /**
     * @param InstanceInterface $file
     * @return string
     */
    public static function getToken(InstanceInterface $file) : string
    {
        return md5(Yii::$app->request->cookieValidationKey . Yii::$app->request->getUserIP() . $file->size . $file->id);
    }

    /**
     * @param $class
     * @return string
     */
    public static function getPath($class) : string
    {
        return Yii::$app->basePath . '/../' . self::getUrl($class);
    }

    /**
     * @param $class
     * @return string
     */
    public static function getUrl($class) : string
    {
        return self::DIRECTORY_FILES . '/' . strtolower(StringHelper::basename($class));
    }

    /**
     * @param $name
     * @return string
     */
    public static function text2url($name) : string
    {

        $url = [
            time(),
            URLify::url($name, 60, "", true),
        ];
        return implode('-', $url);
    }

    /**
     * @param $model
     * @return array
     */
    public static function getFileFields($model) : array
    {
        $fields = [];
        $rules = $model->rules();
        foreach ($rules as $rule) {
            if ($rule[1] == 'file') {
                $fieldsTmp = [];
                if (is_array($rule[0])) {
                    $fieldsTmp = $rule[0];
                } else {
                    $fieldsTmp[] = $rule[0];
                }

                unset($rule[0]);

                foreach ($fieldsTmp as $field) {
                    $fields[$field] = array_merge([$field], $rule);
                }
            }
        }
        return $fields;
    }

    /**
     * @param InstanceInterface $file
     * @param \common\modules\file\helpers\StyleHelper $style
     * @return bool|string
     * @throws \yii\base\Exception
     */
    public static function createPreview(InstanceInterface $file, StyleHelper $style)
    {
        if (!$file || strpos($file->mimetype, 'image') === false) {
            return false;
        }
        $originPath = Yii::$app->basePath . '/../' . $file->path;
        $stylePath = $originPath . '/' . $style->getPath();
        if (!is_dir($stylePath)) {
            BaseFileHelper::createDirectory($stylePath, self::DIRECTORY_PERMISSION);
        }
         $imageManager = new ImageManager();
         $image = $imageManager->make($originPath . '/' . $file->name)->resize($style->width, $style->height, function ($constraint) {
             $constraint->aspectRatio();
         });

     //   $image = $imageManager->make($originPath . '/' . $file->name)->fit($style->width, $style->height);
       // $image = $imageManager->make($originPath . '/' . $file->name)->resize($style->width, $style->height);
        if ($image->save($stylePath . '/' . $file->name, $style->quality)) {
            return $stylePath . '/' . $file->name;
        }
        return false;
    }

}
