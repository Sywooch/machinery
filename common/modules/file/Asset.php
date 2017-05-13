<?php

namespace common\modules\file;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/file/assets';
    public $css = [];

    public $js = [
    ];

}
