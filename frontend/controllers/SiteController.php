<?php
namespace frontend\controllers;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\modules\product\models\ProductRepository;
use frontend\modules\catalog\helpers\CatalogHelper;
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
        $catalog = [];
        $catalog[] = TaxonomyItems::findOne(11);
        $catalog[] = TaxonomyItems::findOne(12);
        
        $models = [];
        $itemsAction = [];
        $itemsNew = [];
        $itemsHit = [];
        
        $terms = TaxonomyItems::find()->where(['vid' => 47])->all();
        
        foreach($catalog as $item){
            $searchModel = new ProductRepository(CatalogHelper::getModelByTerm($item));
            foreach($terms as $term){
                if(!isset($models[$term->id])){
                    $models[$term->id] = [];
                }
                $models[$term->id] = array_merge($models[$term->id],$searchModel->getProducstByIds($searchModel->getItemsByStatus($term, $limit = 10)));
            }
        }
        
        foreach($models as $index => $empty){
            shuffle($models[$index]);
            $models[$index] = array_slice($models[$index],0,10);
        }

        return $this->render('index',[
            'models' => $models,
            'terms' => $terms,
            'slider' => AdsSlider::find()->all(),
            'actions' => AdsActions::find()->with('alias')->all(),
            'reviews' => Review::find()->with('alias')->all(),
        ]);
    }
 
}
