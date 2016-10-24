<?php

namespace frontend\modules\catalog\widgets\Filter;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
     public $sourcePath = '@webroot/../modules/catalog/widgets/Filter/assets';
   // public $basePath = '@webroot';
   // public $baseUrl = '/frontend/modules/catalog/widgets/Filter/assets';

    public $css = [
    ];
    public $js = [
        'filter.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
