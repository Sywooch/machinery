<?php
namespace frontend\modules\catalog\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;
use frontend\modules\catalog\models\Compares;
use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\helpers\CatalogHelper;


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
     
        $compares = Compares::getItems();
        
        if(empty($compares)){
           return $this->render('_empty');
        }
        
        $entityIds = ArrayHelper::map($compares, 'entity_id', 'entity_id', 'model');
        $models = [];
        foreach($entityIds as $model => $ids){
            $modelClass = ModelHelper::getModelClass($model);
            $models[$model] = $modelClass::find()->where(['id'=>$ids])->indexBy('id')->all();
        }
        
        $termIds = array_unique(ArrayHelper::getColumn($compares, 'term_id'));
        $terms = TaxonomyItems::find()->where(['id'=>$termIds])->indexBy('id')->all();
   
        $current = isset($terms[$id]) ? $terms[$id] : reset($terms);
        
        return $this->render('index',[
            'current' => $current,
            'terms' => $terms,
            'models' => CatalogHelper::compareModelByTerm($current, $compares, $models),
        ]);
       
    }
    public function actionRemove($id){

        Compares::deleteAll([
            'entity_id' => $id,
            'session' => $_COOKIE['PHPSESSID']
        ]);
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionToggle(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          
        $id = Yii::$app->request->post('id');
        $model = Yii::$app->request->post('model');

        if(!class_exists($model = ModelHelper::getModelClass($model))){
            throw new InvalidParamException();
        }
        
        if(!($entity = $model::findOne($id))){
            throw new InvalidParamException();
        }
        
        $tree =  TaxonomyHelper::tree($entity->catalog);
        $term = TaxonomyHelper::lastChildren(reset($tree));
        
        if(!$term){
            throw new InvalidParamException();
        }

        $count = Compares::find()
                ->where(['session' => $_COOKIE['PHPSESSID']])
                ->count();
        
        if($count > Compares::MAX_ITEMS_COMPARE){
            return [
                'status' => 'error', 
                'message' => 'Добавлено максимальное количество продуктов в сравнение.'
            ];
        }
        
        $compare = Compares::find()->where([
                'session' => $_COOKIE['PHPSESSID'],
                'entity_id' => $id,
                'model' => ModelHelper::getModelName($model)
             ])->One();

        if(!$compare){
            $compare = new Compares();
            $compare->session = $_COOKIE['PHPSESSID'];
            $compare->entity_id = $entity->id;
            $compare->model = ModelHelper::getModelName($model);
            $compare->term_id = $term->id;
            $compare->save();
        }else{
            $compare->delete();
            return [
                    'status' => 'success', 
                    'action' => 'deleted',
                    'id' => $compare->entity_id,
                    'model' => $compare->model,
                    'count' => $compare->count
                ];
        }
        
        return [
                'status' => 'success', 
                'action' => 'added',
                'id' => $compare->entity_id,
                'model' => $compare->model,
                'count' => $compare->count
            ];
    }
}
