<?php

namespace common\modules\communion;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    //public $sourcePath = '@app/../common/modules/favorites/assets';
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/communion/assets';

    public $css = [];

    public $js = [
        'communion.js'
    ];

    public $depends = [
        JqueryAsset::class,
    ];

}
