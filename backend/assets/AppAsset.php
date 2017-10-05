<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

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
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'css/admin.css',
    ];
    public $js = [
        "bower_components/jquery-ui/jquery-ui.min.js",
        "bower_components/raphael/raphael.min.js",
        "bower_components/jquery-sparkline/dist/jquery.sparkline.min.js",

        "js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
        "js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
        "bower_components/jquery-knob/dist/jquery.knob.min.js",
        "bower_components/moment/min/moment.min.js",
        "bower_components/bootstrap-daterangepicker/daterangepicker.js",
        "bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
        "js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
        "bower_components/jquery-slimscroll/jquery.slimscroll.min.js",
        "bower_components/fastclick/lib/fastclick.js",
        'js/adminlte.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
