<?php
return [
    
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DummyCache', //yii\caching\DummyCache //yii\caching\FileCache   //yii\redis\Cache
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'common\modules\store\components\StoreUrlRule'],
                 ['class' => 'common\modules\store\components\ProductUrlRule'],
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
                'LoginForm' => 'common\models\LoginForm',
                'RegistrationForm' => 'frontend\models\RegistrationForm',
            ],
        ],
        'file' => [
            'class' => 'common\modules\file\Module',
            'storage' => 'common\modules\file\filestorage\storages\StorageDb',
            'storages' => [
                'local' => [
                    'class' => 'common\modules\file\filestorage\storages\StorageLocal',
                    'basePath' => '@app/../files',
                    'baseUrl' => '@web/files'
                ],
            ]
        ],
     //   'language' => [
      //      'class' => 'common\modules\language\LanguageModule',
     //   ],
        'store' => [
            'class' => 'common\modules\store\Module',
            'defaultPageSize' => 21,
            'maxItemsToCompare' => 100,
            'maxItemsToWish' => 100,
            'buyButtonText' => 'В корзину',
        ],
    ], 
];
