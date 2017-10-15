<?php

namespace common\components;


use yii\helpers\Html as BaseHtml;
use sweelix\yii2\plupload\traits\Plupload;

class Html extends BaseHtml
{
    // adding this trait allow easy access to plupload
    use Plupload;
}
