<?php

namespace common\modules\favorites;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    //public $sourcePath = '@app/../common/modules/favorites/assets';
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/favorites/assets';

    public $css = [];

    public $js = [
        'favorite.js'
    ];

    public $depends = [
        JqueryAsset::class,
    ];

}
