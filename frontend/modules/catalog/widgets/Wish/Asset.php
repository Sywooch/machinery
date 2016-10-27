<?php

namespace frontend\modules\catalog\widgets\Wish;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    //public $sourcePath = '@webroot/../modules/catalog/widgets/CatalogMenu/assets';
    public $basePath = '@webroot';
    public $baseUrl = '/frontend/modules/catalog/widgets/Wish/assets';

    public $css = [
    ];
    public $js = [
        'wish.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
