<?php

namespace common\modules\realty\widgets\Filter;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    // public $sourcePath = '@common/modules/realty/widgets/Filter/assets';
   // public $basePath = '@webroot';
    public $baseUrl = '/common/widgets/Filter/assets';

    public $css = [
    ];
    public $js = [
        'filter.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
