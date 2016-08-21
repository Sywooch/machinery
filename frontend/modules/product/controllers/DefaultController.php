<?php
namespace frontend\modules\product\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use frontend\modules\product\models\ProductRepository;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\helpers\CatalogHelper;

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

        $searchModel = new ProductRepository(CatalogHelper::getModelByName($model));
        $product = $searchModel->getProductById($id);

        if(empty($product) || !$product->publish ){
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
        $searchModel = new ProductRepository(CatalogHelper::getModelByName($model));
        $products = $searchModel->getProductsByGroup($id);
        
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
