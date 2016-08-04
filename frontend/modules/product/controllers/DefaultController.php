<?php
namespace frontend\modules\product\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use frontend\modules\product\models\ProductSearch;
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

        $searchModel = new ProductSearch(CatalogHelper::getModelByName($model));
        $product = $searchModel->getProductById($id);
        
        if(empty($product) || !$product->publish ){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->render('index',[
            'product' => $product
        ]);
        
    }

    
}
