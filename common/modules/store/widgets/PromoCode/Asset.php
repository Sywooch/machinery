<?php

namespace common\modules\store\widgets\PromoCode;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/store/widgets/PromoCode/assets';

    public $css = [
    ];
    public $js = [
        'promo.code.widget.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
