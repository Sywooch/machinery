<?php
return [
    
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DummyCache', //yii\caching\DummyCache //yii\caching\FileCache  
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
            'currencyCode' => 'UAH',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ]
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
        'import' => [
            'class' => 'common\modules\import\Module',
        ],
        'store' => [
            'class' => 'common\modules\store\Module',
            'defaultPageSize' => 20,
            'maxItemsToCompare' => 100,
            'maxItemsToWish' => 100,
            'buyButtonText' => 'В корзину',
            'models' => [
                11 => \common\modules\store\models\product\ProductDefault::class,
                12 => \common\modules\store\models\product\ProductPC::class,
                3784 => \common\modules\store\models\product\ProductAV::class,
                3887 => \common\modules\store\models\product\ProductBitovaya::class,
                3888 => \common\modules\store\models\product\ProductBuilding::class,
                3889 => \common\modules\store\models\product\ProductSport::class,
                5408 => \common\modules\store\models\product\ProductHardware::class,
                3891 => \common\modules\store\models\product\ProductAccessories::class,
                3892 => \common\modules\store\models\product\ProductAuto::class
            ],
        ],
    ], 
];
