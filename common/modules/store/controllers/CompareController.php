<?php
namespace common\modules\store\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;
use common\modules\store\models\Compares;
use common\modules\store\models\ComparesSearch;
use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\helpers\CatalogHelper;
use common\modules\store\classes\uus\UUS;


/**
 * Site controller
 */
class CompareController extends Controller
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
    
    public function actionIndex($id = null){
     
        $compareSearch = Yii::$container->get(ComparesSearch::class);
        
        $compares = $compareSearch->items;
        
        if(empty($compares)){
           return $this->render('_empty');
        }
        
        $entityIds = ArrayHelper::map($compares, 'entity_id', 'entity_id', 'model');
        $models = [];
        foreach($entityIds as $model => $ids){
            $modelClass = ModelHelper::getModelClass($model);
            $models[$model] = $modelClass::find()->where(['id' => $ids])->indexBy('id')->all();
        }
        
        $termIds = array_unique(ArrayHelper::getColumn($compares, 'term_id'));
        $terms = TaxonomyItems::find()->where(['id'=>$termIds])->indexBy('id')->all();
   
        $current = isset($terms[$id]) ? $terms[$id] : reset($terms);
               
        return $this->render('index',[
            'compares' => $compares,
            'current' => $current,
            'terms' => $terms,
            'compareModels' => CatalogHelper::compareModelByTerm($current, $compares, $models),
        ]);
       
    }
    public function actionRemove($id){
        $uus = new UUS();
        Compares::deleteAll([
            'id' => $id,
            'session' => $uus->id
        ]);
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionToggle(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if(!class_exists($model = ModelHelper::getModelClass(Yii::$app->request->post('model')))){
            throw new InvalidParamException();
        }
        
        if(!($entity = $model::findOne(Yii::$app->request->post('id')))){
            throw new InvalidParamException();
        }
        
        $tree =  TaxonomyHelper::tree($entity->catalog);
        $term = TaxonomyHelper::lastChildren(reset($tree));
        
        if(!$term){
            throw new InvalidParamException();
        }

        $compareSearch = Yii::$container->get(ComparesSearch::class);
        
        if($compareSearch->count > Compares::MAX_ITEMS_COMPARE){
            return [
                'status' => 'error', 
                'message' => 'Добавлено максимальное количество продуктов в сравнение.'
            ];
        }
        
        if(!($compare = $compareSearch->findOne($entity))){ 
            $compare = Yii::createObject([
                'class' => Compares::class,
                'session' => $compareSearch->uus->id,
                'term_id' => $term->id,
                'entity_id' => $entity->id,
                'model' => ModelHelper::getModelName($entity),
            ]);
            $compare->save();
        }else{
            $compare->delete();
            return [
                    'status' => 'success', 
                    'action' => 'deleted',
                    'id' => $compare->entity_id,
                    'model' => $compare->model,
                    'count' => $compareSearch->count
                ];
        }
        
        return [
                'status' => 'success', 
                'action' => 'added',
                'id' => $compare->entity_id,
                'model' => $compare->model,
                'count' => $compareSearch->count
            ];
    }
}
