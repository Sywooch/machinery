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

    /**
     * @var bool
     */
    public $showRemove = false;

    public function run()
    {
        self::$fieldId++;

        $multiple = FileHelper::isMultiple($this->model, $this->attribute);
        $initialPreview = FileHelper::preview($this->model, $this->attribute);
        $initialPreviewConfig = FileHelper::config($this->model, $this->attribute, $this->showRemove);

        return $this->render('field', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'fieldId' => self::$fieldId,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
            'showRemove' => $this->showRemove,
            'multiple' => $multiple
        ]);
    }

}
