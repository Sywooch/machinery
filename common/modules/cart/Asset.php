<?php

namespace common\modules\cart;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/cart/assets';
    public $css = [
    ];

    public $js = [
        'cart.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
