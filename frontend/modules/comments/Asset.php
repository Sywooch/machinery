<?php

namespace frontend\modules\comments;

use yii\web\AssetBundle;
 
/**
 * Widget asset bundle
 */
class Asset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
        public $basePath = '@webroot';
        public $baseUrl = '@web/frontend/modules/comments/assets';
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
