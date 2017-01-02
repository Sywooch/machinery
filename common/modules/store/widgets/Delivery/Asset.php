<?php

namespace common\modules\store\widgets\Delivery;

use yii\web\AssetBundle;

/**
 * Widget asset bundle
 */
class Asset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/store/widgets/Delivery/asset';
    //public $sourcePath = 'assets';

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'delivery.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
