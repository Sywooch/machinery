<?php

namespace common\modules\orders;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/orders/assets';
    public $css = [
    ];

    public $js = [
    ];
    
    public $depends = [
        JqueryAsset::class,
    ];

}
