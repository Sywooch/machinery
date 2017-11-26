<?php

namespace common\modules\image\widgets\Images;

use yii;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\modules\file\filestorage\Instance;
use common\modules\file\helpers\FileHelper;


class ImagesWidget extends Widget
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
     * @var integer
     */
    public $max;

    public $field;

    public function run()
    {

        return $this->render('input', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'max' => $this->max,
        ]);
    }
}