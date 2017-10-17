<?php

namespace common\modules\file\helpers;

use common\helpers\URLify;
use yii;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper as BaseFileHelper;
use common\modules\file\filestorage\InstanceInterface;
use Intervention\Image\ImageManager;
use yii\helpers\ArrayHelper;
use common\modules\file\filestorage\Instance;
use yii\helpers\Url;

class FileHelper
{

    const DIRECTORY_PERMISSION = 0775;
    const DIRECTORY_FILES = 'files';
    const AJAX_UPLOAD_URL = '/file/manage/upload';

    public static $style;


    /**
     * @param $model
     * @param $attribute
     * @return bool
     */
    public static function isMultiple($model, $attribute)
    {
        $field = FileHelper::getFileFields($model)[$attribute];
        if (isset($field['maxFiles']) && $field['maxFiles'] == 1) {
            return false;
        }
        return true;
    }

    /**
     * @param $model
     * @param $attribute
     * @return null|int
     */
    public static function maxFiles($model, $attribute)
    {
        $field = FileHelper::getFileFields($model)[$attribute];
        return $field['maxFiles'] ?? null;
    }

    /**
     * @param $model
     * @param $attribute
     * @return array
     */
    public static function preview($model, $attribute)
    {
        $instance = $model->{$attribute};

        if (!is_array($instance)) {
            if ($instance) {
                $instance = [$instance];
            } else {
                $instance = [];
            }
        }

        $instance = array_filter($instance);

        if (empty($instance) || !(current($instance) instanceof ActiveRecord)) {
            return [];
        }

        return ArrayHelper::getColumn($instance, function ($item) {
            return $item->path . '/' . $item->name;
        });
    }

    /**
     * @param $model
     * @param $attribute
     * @param bool $showRemove
     * @return array
     */
    public static function config($model, $attribute, $showRemove = false)
    {
        $instance = $model->{$attribute};

        if (!is_array($instance)) {
            if ($instance) {
                $instance = [$instance];
            } else {
                $instance = [];
            }
        }

        $instance = array_filter($instance);

        if (empty($instance) || !(current($instance) instanceof ActiveRecord)) {
            return [];
        }

        return ArrayHelper::toArray($instance, [
            Instance::class => [
                'key' => function ($item) {
                    return $item->id;
                },
                'caption' => function ($item) {
                    return $item->name;
                },
                'size' => function ($item) {
                    return $item->size;
                },
                'url' => function ($item) use ($showRemove) {
                    return $showRemove ? Url::to(['/file/manage/delete', 'id' => $item->id, 'token' => self::getToken($item)]) : '';
                }
            ]
        ]);
    }

    /**
     * @param InstanceInterface $file
     * @return string
     */
    public static function getToken(InstanceInterface $file): string
    {
        return md5(Yii::$app->request->cookieValidationKey . Yii::$app->request->getUserIP() . $file->size . $file->id);
    }

    /**
     * @param $class
     * @return string
     */
    public static function getPath($class): string
    {
        return Yii::$app->basePath . '/../' . self::getUrl($class);
    }

    /**
     * @param $class
     * @return string
     */
    public static function getUrl($class): string
    {
        return self::DIRECTORY_FILES . '/' . strtolower(StringHelper::basename($class));
    }

    /**
     * @param $name
     * @return string
     */
    public static function text2url($name): string
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
    public static function getFileFields($model): array
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
