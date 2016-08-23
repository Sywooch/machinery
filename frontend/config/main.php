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
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'cart' => [
            'class' => 'frontend\modules\cart\Module',
        ],
        'product' => [
            'class' => 'common\modules\product\Module',
        ],
        'catalog' => [
            'class' => 'frontend\modules\catalog\Module',
        ],
        'comments' => [
            'class' => 'frontend\modules\comments\Module'
	],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
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
            'class' => 'frontend\modules\cart\components\Cart',
        ],
        'event' => [
            'class' => 'frontend\components\EventComponent',
            'events' => [
                \frontend\modules\rating\components\RatingBehavior::RATING_UPDATE => function($e){
                    $modelName = "\\backend\\models\\" . $e->sender->model;
                    $model = $modelName::findOne($e->sender->entity_id);
                                       
                    $ratingRepository = new frontend\modules\rating\models\RatingRepository();
                    $commentsRepository = new frontend\modules\comments\models\CommentsRepository();
                    $ids = $commentsRepository->getCommentIds([
                        'entity_id' => $e->sender->entity_id,
                        'model' => $e->sender->model
                    ]);
                   
                    $model->rating = $ratingRepository->getAvgRating([
                        'entity_id' => $ids,
                        'model' => \common\helpers\ModelHelper::getModelName(\frontend\modules\comments\models\Comments::class)
                    ]);
                    $model->save();
                }
            ]
        ],
        'urlManager' => [
            'rules' => [
                ['class' => 'frontend\components\AliasRule'],
                ['class' => 'common\modules\product\components\ProductUrlRule'],
                ['class' => 'frontend\modules\catalog\components\CatalogUrlRule'],  
            ],
	],
    ],
    'params' => $params,
];
