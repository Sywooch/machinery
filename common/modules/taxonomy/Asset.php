<?php

namespace common\modules\taxonomy;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/taxonomy/assets';
    public $css = [
        'taxonomy.css'
    ];

    public $js = [
        'taxonomy.js',
        'jquery.nestable.js'
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
