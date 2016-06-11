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
    public function actionIndex($catalogId, $productId)
    {   

        $term = TaxonomyItems::findOne($catalogId);

        if($term === null){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        
        $searchModel = new ProductSearch(CatalogHelper::getModelByTerm($term));
        $product = $searchModel->getProductById($productId);
        
        if(empty($product) 
                || !$product->publish 
                || Yii::$app->request->url != Url::to(['/product', 'entity' => $product])){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->render('index',[
            'current' => $term,
            'product' => $product
        ]);
        
    }

    
}
