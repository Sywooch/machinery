<?php

namespace common\modules\file\widgets\FileInputAvatar;

use yii;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\modules\file\filestorage\Instance;
use common\modules\file\helpers\FileHelper;


class FileInputAvatarWidget extends Widget
{
    /**
     * @var mixed
     */
    public $model;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $uploadUrl;

    public function run()
    {
        $initialPreview = [];
        $initialPreviewConfig = [];

        if ($this->model->{$this->attribute} && array_filter($this->model->{$this->attribute}) && current($this->model->{$this->attribute}) instanceof yii\db\ActiveRecord) {

            $initialPreview = ArrayHelper::getColumn($this->model->{$this->attribute}, function ($item) {
                return $item->path . '/' . $item->name;
            });

            $initialPreviewConfig = ArrayHelper::toArray($this->model->{$this->attribute}, [
                Instance::class => [
                    'key' => function ($item) {
                        return $item->id;
                    },
                    'size' => function ($item) {
                        return $item->size;
                    }
                ]
            ]);
        }

        return $this->render('field', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
            'uploadUrl' => $this->uploadUrl,
        ]);
    }

}
