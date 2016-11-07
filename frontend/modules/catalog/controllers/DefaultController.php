<?php
namespace frontend\modules\catalog\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\helpers\ModelHelper;
use common\modules\product\models\ProductRepository;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyItemsSearch;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\Compares;
use frontend\modules\catalog\components\Url;

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
    
    public function actionCatalog(){

        $taxonomyItemsSearch = new TaxonomyItemsSearch();
        $models = $taxonomyItemsSearch->getItemsByVid(Yii::$app->params['catalog']['vocabularyId']);
        
        return $this->render('catalog',[
            'menuItems' => TaxonomyHelper::tree($models),
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex(Url $filter)
    {   

        if(!$filter->main){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        $productModel = ModelHelper::getModelByTerm($filter->main);
        $searchModel = new ProductRepository($productModel);

        if(!$filter->category){
            $childrensTerms = TaxonomyItems::findAll([
                'vid' => $filter->main->vid,
                'pid' => $filter->main->id
            ]); 
            
            if($childrensTerms){
                $items = [];
                foreach($childrensTerms as $childrenTerm){
                    $products = $searchModel->getProductsByIds($searchModel->getCategoryMostRatedItems($childrenTerm));
                    $items[$childrenTerm->id] = [
                        'term' => $childrenTerm,
                        'products' => $products
                    ];
                }
                return $this->render('categories',[
                    'parent' => $filter->main,
                    'items' => $items
                ]);
            }
        }
        $dataProvider = $searchModel->searchItemsByFilter($filter);
        $products = $searchModel->getProductsByIds($dataProvider->getKeys());
        
        $productModelName = ModelHelper::getModelName($productModel);
        $compares = ArrayHelper::map(Compares::getItems(),'entity_id','entity_id','model');
     
        return $this->render('index',[
            'parent' => $filter->main,
            'current' => $filter->category,
            'dataProvider' => $dataProvider,
            'products' => $products,
            'compareIds' => isset($compares[$productModelName]) ? $compares[$productModelName] : [], 
            'search' => $searchModel,
        ]);
    }

}
