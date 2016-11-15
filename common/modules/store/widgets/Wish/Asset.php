<?php

namespace common\modules\store\widgets\Wish;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
 
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    //public $sourcePath = '@app/../common/modules/store/widgets/Wish/assets';
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/store/widgets/Wish/assets';

    public $css = [
    ];
    public $js = [
        'wish.js',
    ];
        
    public $depends = [
        JqueryAsset::class,
    ];
	
}
