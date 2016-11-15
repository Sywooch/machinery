<?php
namespace common\modules\store\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\product\models\ProductRepository;
use common\helpers\ModelHelper;
use yii\helpers\ArrayHelper;
use common\modules\store\models\ProductInterests;
use common\modules\store\models\ProductDefault;
use common\modules\store\models\ComparesSearch;

/**
 * Site controller
 */
class ProductController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex($id, $model)
    {   
        $product = ProductDefault::findOne($id);
        
        if(empty($product)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        
        ProductInterests::push($product);
        
        $compareSearch = Yii::$container->get(ComparesSearch::class);

        $compares = ArrayHelper::map($compareSearch,'entity_id','entity_id','model');
        return $this->render('index',[
            'product' => $product,
            'compareIds' => isset($compares[$model]) ? $compares[$model] : [], 
        ]);
        
    }
    
    /**
     *
     * @return mixed
     */
    public function actionOtzyvy($id, $model, $tab)
    {   
        $searchModel = new ProductRepository(ModelHelper::getModelByName($model));
        $ids = $searchModel->getProductsByGroup($id);
        $products = $searchModel->getProductsByIds($ids);

        if(empty($products)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        $compares = ArrayHelper::map(Compares::getItems(),'entity_id','entity_id','model');
        return $this->render('index',[
            'products' => $products,
            'product' => reset($products),
            'compareIds' => isset($compares[$model]) ? $compares[$model] : [], 
            'tab' => $tab
        ]);
        
    }

    
}
