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
                'User' => 'backend\models\User',
                'LoginForm' => 'common\models\LoginForm',
                'RegistrationForm' => 'frontend\models\RegistrationForm',
            ],
        ],
        'file' => [
            'class' => 'common\modules\file\Module',
        ],
        'orders' => [
            'class' => 'common\modules\orders\Module',
        ],
        'import' => [
            'class' => 'common\modules\import\Module',
        ],
    ], 
];
