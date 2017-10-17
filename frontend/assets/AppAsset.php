<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'js/slick/slick.css',
        'js/photoswipe/photoswipe.css',
        'js/photoswipe/default-skin/default-skin.css',
        'css/style.css',
        'css/dev.css',
    ];
    public $js = [
        'js/slick/slick.min.js',
        'js/jquery.formstyler.min.js',
        'js/jquery.ui.touch-punch.min.js',
        'js/jquery.cookie.js',
        'js/jquery.hoverIntent.js',
        'js/photoswipe/photoswipe.min.js',
        'js/photoswipe/photoswipe-ui-default.min.js',
        'js/functions.js',
        'js/scripts.js',
        'js/dev.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
//         'app\assets\BootstrAsset',
    ];
}
