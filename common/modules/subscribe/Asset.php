<?php

namespace common\modules\subscribe;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    //public $sourcePath = '@app/../common/modules/favorites/assets';
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/subscribe/assets';

    public $css = [];

    public $js = [
        'subscribe.js'
    ];

    public $depends = [
        JqueryAsset::class,
    ];

}
