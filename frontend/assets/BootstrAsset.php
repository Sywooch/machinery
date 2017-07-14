<?php
 
namespace app\assets;
 
class BootstrAsset extends \yii\web\AssetBundle
{
 
    public $sourcePath = '@bower/bootstrap/dist';
    public $js = [
        'js/bootstrap.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
 
}