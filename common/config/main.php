<?php
return [

    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DummyCache', //yii\caching\DummyCache //yii\caching\FileCache   //yii\redis\Cache
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['en'=>'en-EN', 'fr'=>'fr-FR', 'de'=>'de-DE', 'es-*', 'uk'=>'uk-UA', 'ru'=>'ru-RU'],

            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action:(login|logout)>' => 'user/security/<action>',
            ],
        ],
        'formatter' => [
            'class' => 'frontend\components\Formatter',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd/MM/yy hh:mm',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'currencyCode' => 'UAH'
        ],

    ],
    'modules' => [
        'search' => [
            'class' => 'common\modules\search\Module',
            'driver' => 'common\modules\search\drivers\PSG\PsgSearch',
            'models' => [
                \common\models\Advert::class => [
                    'indexItems' => 500,
                    'indexFields' => ['title', 'body'],
                    'with' => ['files', 'terms', 'alias'],
                ]
            ]
        ],
        'comments' => [
            'class' => 'common\modules\comments\Module',
            'maxThread' => 2
        ],
        'communion' => [
            'class' => 'common\modules\communion\Module',
        ],
        'notice' => [
            'class' => 'common\modules\notice\Module',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['root'],
            'modelMap' => [
                'Account' => 'frontend\models\Account',
                'SettingsForm' => 'frontend\models\SettingsForm',
                'Profile' => 'frontend\models\Profile',
                'User' => 'common\models\User',
                'LoginForm' => 'common\models\LoginForm'
            ],
        ],
        'file' => [
            'class' => 'common\modules\file\Module',
            'storage' => 'common\modules\file\filestorage\storages\StorageDb',
            'storages' => [
                'local' => [
                    'class' => 'common\modules\file\filestorage\storages\StorageLocal',
                    'basePath' => '@app/../files',
                    'baseUrl' => '/files'
                ],
            ]
        ],
        'image' => [
            'class' => 'common\modules\image\Module',
        ],
        'language' => [
            'class' => 'common\modules\language\LanguageModule',
        ],
    ],
];
