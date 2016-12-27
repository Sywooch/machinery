<?php

namespace common\modules\store\widgets\CatalogMenu;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/../common/modules/store/widgets/CatalogMenu/assets';
    //public $basePath = '@webroot';
    //public $baseUrl = '/frontend/modules/catalog/widgets/CatalogMenu/assets';

    public $css = [
        'catalog.menu.css',
    ];
    public $js = [
        'catalog.menu.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}