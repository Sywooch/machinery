<?php

namespace common\modules\address\widgets\Field;

use yii\web\AssetBundle;

/**
 * Widget asset bundle
 */
class Asset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/address/widgets/Field/asset';
    //public $sourcePath = 'assets';
    /**
     * @var string Redactor language
     */
    public $language;

    /**
     * @var array Redactor plugins array
     */
    public $plugins = [];

    /**
     * @inheritdoc
     */
    public $css = [
        'address.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'http://api-maps.yandex.ru/2.1/?lang=ru_RU',
        'address.js',
        '/node_modules/jquery-json/src/jquery.json.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
