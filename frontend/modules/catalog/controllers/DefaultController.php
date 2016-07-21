<?php
namespace frontend\modules\catalog\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\file\models\File;
use frontend\modules\catalog\components\FilterParams;
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
    public function actionIndex(FilterParams $filter)
    {   
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];

        if(!isset($filter->index[$catalogVocabularyId]) || !($filter->index[$catalogVocabularyId] instanceof TaxonomyItems)  ){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $term = $filter->index[$catalogVocabularyId];

        if(0 && !$term->pid){
            $childrensTerms = TaxonomyItems::findAll([
                'vid' => $term->vid,
                'pid' => $term->id
            ]); 
            
            if($childrensTerms){
                $items = [];
                foreach($childrensTerms as $childrenTerm){
                    $searchModel = new ProductSearch(CatalogHelper::getModelByTerm($childrenTerm));
                    $items[$childrenTerm->id] = [
                        'term' => $childrenTerm,
                        'dataProvider' => $searchModel->getCategoryMostRatedItems($childrenTerm)
                    ];
                }
                return $this->render('categories',[
                    'current' => $term,
                    'items' => $items
                ]);
            }
        }

        $searchModel = new ProductSearch(CatalogHelper::getModelByTerm($term));
        $dataProvider = $searchModel->searchItemsByFilter($filter);
        $products = $dataProvider->products;
        $files = File::getFilesBatch($products, 'photos');
        
        return $this->render('index',[
            'current' => $term,
            'dataProvider' => $dataProvider,
            'products' => $products,
            'files' => $files,
            'search' => $searchModel,
        ]);
        
    }

    
}
