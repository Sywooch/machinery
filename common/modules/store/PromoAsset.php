<?php

namespace common\modules\store;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class PromoAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/store/assets';

    public $css = [
        'promo.code.css'
    ];
    public $js = [
        'promo.code.js'
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
