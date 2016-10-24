<?php

namespace frontend\modules\catalog\widgets\Compare;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    //public $sourcePath = '@webroot/../modules/catalog/widgets/CatalogMenu/assets';
    public $basePath = '@webroot';
    public $baseUrl = '/frontend/modules/catalog/widgets/Compare/assets';

    public $css = [
    ];
    public $js = [
        'compare.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
