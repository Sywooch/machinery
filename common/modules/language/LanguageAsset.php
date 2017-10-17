<?php

namespace common\modules\language;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class LanguageAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/language/assets';
    public $css = [
        'language.css'
    ];

    public $js = [
        'language.js'
    ];

    public $depends = [
        JqueryAsset::class,
    ];

}
