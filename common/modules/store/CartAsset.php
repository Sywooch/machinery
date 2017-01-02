<?php

namespace common\modules\store;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class CartAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/modules/store/assets';
    //public $basePath = '@webroot';
  //  public $baseUrl = '/frontend/modules/cart/assets';
    public $css = [
        'cart.css',
    ];

    public $js = [
        'cart.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
