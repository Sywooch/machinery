<?php
namespace frontend\modules\catalog\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
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
    public function actionIndex(array $filter)
    {   
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
        if(!isset($filter[$catalogVocabularyId]) || !is_numeric($filter[$catalogVocabularyId])){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $term = TaxonomyItems::findOne($filter[$catalogVocabularyId]);

        if($term === null){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        if(!$term->pid){
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
        
        $searchModel = new ProductSearch(CatalogHelper::getModelByTerm($term->parent));
        return $this->render('index',[
            'current' => $term,
            'filter' => $filter,
            'dataProvider' => $searchModel->searchItemsByParams(Yii::$app->request->queryParams),
            'search' => $searchModel,
        ]);
        
    }

    
}
