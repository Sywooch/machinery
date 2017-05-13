<?php

namespace common\modules\file\widgets\FileInput;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    // public $sourcePath = '@app/../common/modules/realty/widgets/Filter/assets';
    // public $basePath = '@webroot';
    public $baseUrl = '/common/modules/file/widgets/FileInput/assets';

    public $css = [
        'fileinput/css/fileinput.css',
        'file.input.widget.css'
    ];
    public $js = [
        'fileinput/js/fileinput.js',
        'fileinput/themes/explorer/theme.js',
        'file.input.widget.js'
    ];

    public $depends = [
        JqueryAsset::class,
    ];

}
