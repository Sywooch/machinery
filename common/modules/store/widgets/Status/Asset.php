<?php

namespace common\modules\store\widgets\Status;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
   public $sourcePath = '@common/modules/store/widgets/Status/asset';
   
    public $css = [
        'status.widget.css',
    ];
    public $js = [
    ]; 
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
