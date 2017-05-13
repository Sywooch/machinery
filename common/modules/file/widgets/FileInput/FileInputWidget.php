<?php
namespace common\modules\file\widgets\FileInput;

use yii;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\modules\file\filestorage\Instance;
use common\modules\file\helpers\FileHelper;


class FileInputWidget extends Widget
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
     * @var int
     */
    public static $fieldId = 0;

    public function run()
    {
        self::$fieldId++;

        $initialPreview = [];
        $initialPreviewConfig = [];

        if ($this->model->{$this->attribute}) {
            $initialPreview = ArrayHelper::getColumn($this->model->{$this->attribute}, function ($item) {
                return $item->path . '/' . $item->name;
            });

            $initialPreviewConfig = ArrayHelper::toArray($this->model->{$this->attribute}, [
                Instance::class => [
                    'caption' => function ($item) {
                        return $item->name;
                    },
                    'size' => function ($item) {
                        return $item->size;
                    },
                    'url' => function ($item) {
                        return Url::to(['/file/manage/delete', 'id' => $item->id, 'token' => FileHelper::getToken($item)]);
                    }
                ]
            ]);
        }


        return $this->render('field', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'fieldId' => self::$fieldId,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig
        ]);
    }

}
