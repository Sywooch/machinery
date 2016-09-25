<?php

namespace common\modules\orders\widgets\Status;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
   public $sourcePath = '@common/modules/orders/widgets/Status/asset';
   
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
