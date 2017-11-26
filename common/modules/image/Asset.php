<?php

namespace common\modules\image;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/image/assets';
    public $css = [];

    public $js = [
        'plupload/js/plupload.full.min.js',
    ];

}