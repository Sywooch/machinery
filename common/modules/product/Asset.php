<?php

namespace common\modules\product;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/frontend/modules/product/assets';

    public $css = [
    ];
    public $js = [
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
