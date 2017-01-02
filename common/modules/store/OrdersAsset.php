<?php

namespace common\modules\store;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class OrdersAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/store/assets';
    public $css = [
    ];

    public $js = [
    ];
    
    public $depends = [
        JqueryAsset::class,
    ];

}
