<?php
namespace frontend\controllers;

use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\components\MathCaptchaAction;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\ModelHelper;
use common\models\Advert;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'common\actions\ErrorAction',
            ],
            'captcha' => [
                'class' => MathCaptchaAction::class,
               // 'fixedVerifyCode' => YII_ENV_DEV ? '42' : null,
                'fontFile' => '@frontend/web/fonts/DroidSans.ttf',
                'backColor' => 0xe7e7e7,
                'foreColor' => 0x59656c,
                'minLength' => 0,
                'maxLength' => 100,
                'width' => 150,
                'height' => 40
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $categories = TaxonomyItems::find()
            ->where(['vid' => 2])
            ->andWhere(['pid'=>0])
            ->orderBy(['weight' => SORT_ASC])
            ->all();
        $last_adverts = Advert::find()->where(['status'=>1])->limit(10)->all();
        return $this->render('index', [
            'categories' => $categories,
            'last_adverts' => $last_adverts,
        ]);
    }
}

