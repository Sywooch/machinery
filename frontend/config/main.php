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
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'cart' => [
            'class' => 'frontend\modules\cart\Module',
        ],
        'comments' => [
            'class' => 'frontend\modules\comments\Module'
	],
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                'profile' => 'frontend\controllers\ProfileController'
            ],
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
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
                                       
                    $commentsRepository = new frontend\modules\comments\models\CommentsRepository();
                    $ids = $commentsRepository->getCommentIds([
                        'entity_id' => $e->sender->entity_id,
                        'model' => $e->sender->model
                    ]);
                    
                    $ratingRepository = new frontend\modules\rating\models\RatingRepository();
                    $model->rating = $ratingRepository->getAvgRating([
                        'entity_id' => $ids,
                        'model' => \common\helpers\ModelHelper::getModelName(\frontend\modules\comments\models\Comments::class)
                    ]);   
                    $model::updateAll([
                            'rating' => $model->rating,
                            'comments' => count($ids)
                        ], ['group' => $model->group]);
                }
            ]
        ],
        'urlManager' => [
            'rules' => [
                ['class' => 'frontend\components\AliasRule'],
                'user/<userId:\d+>/wish' => 'store/wish',
                'user/<userId:\d+>/wish/remove/<id:\d+>' => 'store/wish/remove'
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
