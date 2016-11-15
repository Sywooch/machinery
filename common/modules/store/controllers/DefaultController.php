<?php
namespace common\modules\store\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\store\models\ProductDefault;
use common\modules\store\components\StoreUrlRule;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\Finder;


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
    public function actionIndex(StoreUrlRule $url)
    {   
        if(!$url->main){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        
        $product = Yii::$container->get(ProductDefault::class);
        $finder = Yii::$container->get(Finder::class, [$product]);
        $dataProvider = $finder->search($url);
        return $this->render('index',[
            'finder' => $finder,
            'url' => $url,
            'dataProvider' => $dataProvider,
            'parent' => $url->main,
            'current' => $url->category,
            'products' => $dataProvider->models,
            'compareIds' => [],
        ]);
        
       
    }
    
    /**
     *
     * @return mixed
     */
    public function actionSubCategories(StoreUrlRule $url)
    {   
        if(!$url->main){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        
        $product = Yii::$container->get(ProductDefault::class);
        $finder = Yii::$container->get(Finder::class, [$product]);

        
        $childrensTerms = TaxonomyItems::findAll([
            'vid' => $url->main->vid,
            'pid' => $url->main->id
        ]); 

        if(!$childrensTerms){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $items = [];
        foreach($childrensTerms as $childrenTerm){
            $products = $finder->findById($finder->getMostRatedId($childrenTerm));
            $items[$childrenTerm->id] = [
                'term' => $childrenTerm,
                'products' => $products
            ];
        }
        return $this->render('categories',[
            'parent' => $url->main,
            'items' => $items
        ]);
 
    }
 
}
