<?php
namespace common\modules\product\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\product\models\ProductRepository;
use common\helpers\ModelHelper;

/**
 * Site controller
 */
class DefaultController extends Controller
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

        $searchModel = new ProductRepository(ModelHelper::getModelByName($model));
        $product = $searchModel->getProductById($id);
       
        if(empty($product)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->render('index',[
            'product' => $product,
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
        $products = $searchModel->getProducstByIds($ids);
        
       
        
        if(empty($products)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->render('index',[
            'products' => $products,
            'product' => reset($products),
            'tab' => $tab
        ]);
        
    }

    
}
