<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use frontend\models\ProductSearch;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\helpers\CatalogHelper;

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
    public function actionIndex($catalogId)
    {   
        $term = TaxonomyItems::findOne($catalogId);
        
        if($term === null){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
       
        $searchModel = new ProductSearch(CatalogHelper::getModelByTerm($term));
        $product = $searchModel->searchItemsByParams(Yii::$app->request->queryParams);
        
        if(empty($product)){
             throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
       
        return $this->render('index',[
            'catalog' => $term,
            'dataProvider' => $product
        ]);
        
    }

    
}
