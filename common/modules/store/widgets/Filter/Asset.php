<?php

namespace common\modules\store\widgets\Filter;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
     public $sourcePath = '@app/../common/modules/store/widgets/Filter/assets';
   // public $basePath = '@webroot';
   // public $baseUrl = '/common/modules/store/widgets/Filter/assets';

    public $css = [
    ];
    public $js = [
        'filter.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
