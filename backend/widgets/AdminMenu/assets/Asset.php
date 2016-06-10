<?php

namespace backend\widgets\AdminMenu\assets;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@webroot/../widgets/AdminMenu';
   //public $basePath = '@webroot/../widgets/AdminMenu';
   // public $baseUrl = '@web/admin/../widgets/AdminMenu';
    public $css = [
        'css/admin-menu.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
