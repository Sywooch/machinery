<?php

namespace backend\widgets\AdminMenu;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@webroot/../widgets/AdminMenu/assets';
  
    public $css = [
        'admin.menu.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
