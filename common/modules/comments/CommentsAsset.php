<?php

namespace common\modules\comments;

use yii\web\AssetBundle;

/**
 * Widget asset bundle
 */
class CommentsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    public $baseUrl = '/common/modules/comments/assets';
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
        'comments.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'comments.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}
