<?php
namespace frontend\controllers;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\modules\product\models\ProductRepository;
use frontend\modules\catalog\helpers\CatalogHelper;
use common\helpers\ModelHelper;
use backend\models\AdsSlider;
use backend\models\AdsActions;
use backend\models\Review;

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
                'class' => 'yii\captcha\CaptchaAction',
             
                'maxLength' => 5,
                'minLength' => 4,
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
        
                return $this->render('index');
     
        
        $catalog = TaxonomyItems::findAll([11,12,3784,3887,3888,3889,5408,3891,3892]);
        $models = Yii::$app->cache->get('index-models');
        
        if($models === false){
            $models = [
                'top' => [],
                'discount' => [],
                'interests' => []
            ];
            $topTerm = TaxonomyItems::findOne(1095);
            foreach($catalog as $item){
                $searchModel = new ProductRepository(ModelHelper::getModelByTerm($item));
                $models['top'] = array_merge($models['top'],$searchModel->getProductsByIds($searchModel->getItemsByStatus($topTerm, $limit = 14)));
                $models['discount'] = array_merge($models['discount'],$searchModel->getProductsByIds($searchModel->getItemsDiscount($limit = 14)));
                $models['interests'] = array_merge($models['interests'],$searchModel->getProductsBySku($searchModel->getItemsInterests($limit = 14)));

            }
            foreach($models as $index => $empty){
                shuffle($models[$index]);
                $models[$index] = array_slice($models[$index],0,14);
            }
            
            Yii::$app->cache->set('index-models', $models, 60*5);
        }

        return $this->render('index',[
            'models' => $models,
            'terms' => $terms,
            'slider' => AdsSlider::find()->all(),
            'actions' => AdsActions::find()->with('alias')->all(),
            'reviews' => Review::find()->with('alias')->all(),
        ]);
    }
    
   
    public function actionIndex2()
    {

        // Наследование по ссылке
        $example = function () use (&$message) {
            var_dump($message);
        };


        // Измененное в родительской области видимости значение
        // остается тем же внутри вызова функции
        $message = 'world';
        echo $example();
    }
 
}

