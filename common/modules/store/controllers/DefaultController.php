<?php
namespace common\modules\store\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\store\models\product\ProductDefault;
use common\modules\store\components\StoreUrlRule;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\Finder;


/**
 * Site controller
 */
class DefaultController extends Controller
{

    /**
     * @param StoreUrlRule $url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex(StoreUrlRule $url)
    {   
        if(!$url->main){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $module = Yii::$app->getModule('store');
        $model = $module->models[$url->main->id];
        $finder = Yii::$container->get(Finder::class, [new $model]);

        return $this->render('index',[
            'finder' => $finder,
            'url' => $url,
            'dataProvider' => $finder->searchByUrl($url),
            'sort' => $finder->sort,
            'parent' => $url->main,
            'current' => $url->category,
        ]);
        
       
    }

    /**
     * @param StoreUrlRule $url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSubCategories(StoreUrlRule $url)
    {   
        if(!$url->main){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        
        $module = Yii::$app->getModule('store');
        $model = $module->models[$url->main->id];
        $finder = Yii::$container->get(Finder::class, [new $model]);
        
        $childrensTerms = TaxonomyItems::findAll([
            'vid' => $url->main->vid,
            'pid' => $url->main->id
        ]); 

        if(!$childrensTerms){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $items = [];
        foreach($childrensTerms as $childrenTerm){
            $products = $finder->getProductsByIds($finder->getMostRatedId($childrenTerm));
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
