<?php

namespace common\modules\store\widgets\Compare;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    //public $sourcePath = '@app/../common/modules/store/widgets/Compare/assets';
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/store/widgets/Compare/assets';

    public $css = [
    ];
    public $js = [
        'compare.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
