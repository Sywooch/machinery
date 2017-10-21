<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'homeUrl' => '/',
    'timeZone' => 'Europe/Minsk',
    'language' => 'en-EN',
//    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [],
            'modelMap' => [
                'RegistrationForm' => 'frontend\models\RegistrationForm',
            ],
            'layout' => '@frontend/views/layouts/account',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'common\modules\language\DbMessageSource',
                    //'basePath' => '@app/messages',
                    'forceInsert' => true,
                    'sourceLanguage' => 'en-EN'
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cart' => [
            'class' => 'common\modules\store\components\Cart',
        ],
        'urlManager' => [
            'rules' => [
                ['class' => 'frontend\components\AliasRule'],
                ['class' => 'frontend\components\CatalogRule'],
                'object/<id:\d+>' => 'advert/view',
//                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
//                'advert/options/<opt: \w+>' => 'advert/options',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@frontend/views/user'
                ],
            ],
        ],
    ],
    'params' => $params,
];
