<?php
namespace common\modules\store\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\modules\store\models\compare\Compares;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use common\modules\store\helpers\ProductHelper;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\store\helpers\CatalogHelper;
use common\modules\store\classes\uus\UUS;
use common\modules\store\Finder;

/**
 * Site controller
 */
class CompareController extends Controller
{
    
    public function actionIndex($id = null){
     
        $finder = Yii::$container->get(Finder::class);
        
        if(empty($compares = $finder->getCompareItems())){
           return $this->render('_empty', []);
        }
  
        $entityIds = ArrayHelper::map($compares, 'entity_id', 'entity_id', 'model');
        $models = [];
        foreach($entityIds as $model => $ids){
            $modelClass = ProductHelper::getClass($model);
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
        
        $model = ProductHelper::getModel(Yii::$app->request->post('model'));
        
        if(!$model){
            throw new BadRequestHttpException();
        }

        $finder = Yii::$container->get(Finder::class, [$model]);
        
        if(!($entity = $finder->getProductById(Yii::$app->request->post('id')))){
            throw new BadRequestHttpException();
        }
        
        $tree =  TaxonomyHelper::tree($entity->catalog);
        $term = TaxonomyHelper::lastChildren(reset($tree));
        
        if(!$term){
            throw new BadRequestHttpException();
        }

        if($finder->comparesSearch->count > $finder->module->maxItemsToCompare){
            return [
                'status' => 'error', 
                'message' => 'Добавлено максимальное количество продуктов в сравнение.'
            ];
        }
 
        if(!($compare = $entity->compare)){ 
            $compare = Yii::createObject([
                'class' => Compares::class,
                'session' => $finder->uus->id,
                'term_id' => $term->id,
                'entity_id' => $entity->id,
                'model' => StringHelper::basename($entity::className()),
            ]);
            $compare->save();
        }else{
            $compare->delete();
        }
        
        return [
                'status' => 'success', 
                'action' => $compare->isNewRecord ? 'deleted' : 'added' ,
                'id' => $compare->entity_id,
                'model' => $compare->model,
                'count' => $finder->comparesSearch->count
            ];
    }
}
