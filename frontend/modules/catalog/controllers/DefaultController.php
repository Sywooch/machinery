<?php
namespace frontend\modules\catalog\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\modules\file\models\FileRepository;
use frontend\modules\catalog\components\FilterParams;
use common\modules\product\models\ProductRepository;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\helpers\CatalogHelper;
use common\models\AliasRepository;

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
        $catalogMain = ArrayHelper::getValue($filter->index, "{$catalogVocabularyId}.0");
        $catalogSub = ArrayHelper::getValue($filter->index, "{$catalogVocabularyId}.1");
        
        if(!$catalogMain){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        
        $searchModel = new ProductRepository(CatalogHelper::getModelByTerm($catalogMain));
        
        if(!$catalogSub){
            $childrensTerms = TaxonomyItems::findAll([
                'vid' => $catalogMain->vid,
                'pid' => $catalogMain->id
            ]); 
            
            if($childrensTerms){
                $items = [];
                foreach($childrensTerms as $childrenTerm){
                    $products = $searchModel->getProducstByIds($searchModel->getCategoryMostRatedItems($childrenTerm));
                    //print_r($products); exit('s');
                    $files = FileRepository::getBatch($products, 'photos');
                    $aliases = AliasRepository::getBatch($products, 'photos');
                    $items[$childrenTerm->id] = [
                        'term' => $childrenTerm,
                        'products' => $products,
                        'aliases' => $aliases,
                        'files' => $files
                    ];
                }
                return $this->render('categories',[
                    'parent' => $catalogMain,
                    'items' => $items
                ]);
            }
        }
        
        $filter->index = CatalogHelper::clearId($catalogMain, $filter->index);
        $dataProvider = $searchModel->searchItemsByFilter($filter);
        $products = $searchModel->getProducstsByGroups($dataProvider->getKeys());
        $files = FileRepository::getBatch($products, 'photos');
        $aliases = AliasRepository::getBatch($products, 'photos');
        
        return $this->render('index',[
            'parent' => $catalogMain,
            'current' => $catalogSub,
            'dataProvider' => $dataProvider,
            'products' => $products,
            'files' => $files,
            'aliases' => $aliases,
            'search' => $searchModel,
        ]);
        
    }

}
