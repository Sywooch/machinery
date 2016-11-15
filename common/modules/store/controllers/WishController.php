<?php
namespace common\modules\store\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\store\models\Wishlist;
use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;
use common\modules\store\models\WishlistSearch;
use backend\models\User;

/**
 * Site controller
 */
class WishController extends Controller
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
    
    public function actionIndex($userId){
        $user = User::findOne($userId);
        
        if(!$user){
            throw new NotFoundHttpException('Страница не найдена.');
        }
        
        $wishSearch = Yii::$container->get(WishlistSearch::class);
        
        $wishList = $wishSearch->getItems($user);
        if(empty($wishList)){
           return $this->render('_empty', ['user' => $user]);
        }
        
        $entityIds = ArrayHelper::map($wishList, 'entity_id', 'entity_id', 'model');
        $models = [];
        foreach($entityIds as $model => $ids){
            $modelClass = ModelHelper::getModelClass($model);
            $models[$model] = $modelClass::find()->where(['id' => $ids])->indexBy('id')->all();
        }
        
        return $this->render('index',[
            'wishList' => $wishList,
            'models' => $models,
            'user' => $user
        ]);
       
    }
        
    public function actionRemove(array $id){
               
        Wishlist::deleteAll([
            'id' => $id,
            'user_id' => Yii::$app->user->id
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
        
        $wishSearch = Yii::$container->get(WishlistSearch::class);
        
        if($wishSearch->count > Wishlist::MAX_ITEMS_WISH){
            return [
                'status' => 'error', 
                'message' => 'Добавлено максимальное количество продуктов в избранном.'
            ];
        }
        
        
        $wish = Wishlist::find()->where([
                'user_id' => Yii::$app->user->id,
                'entity_id' => $id,
                'model' => ModelHelper::getModelName($model)
             ])->One();

        if(!($wish = $wishSearch->getItem($entity))){
             $wish = Yii::createObject([
                'class' => Wishlist::class,
                'user_id' => Yii::$app->user->id,
                'entity_id' => $entity->id,
                'model' => ModelHelper::getModelName($model)
            ]);
            $wish->save();
        }else{
            $wish->delete();
            return [
                    'status' => 'success', 
                    'action' => 'deleted',
                    'id' => $wish->entity_id,
                    'model' => $wish->model,
                    'count' => $wishSearch->count
                ];
        }
        
        return [
                'status' => 'success', 
                'action' => 'added',
                'id' => $wish->entity_id,
                'model' => $wish->model,
                'count' => $wishSearch->count
            ];
    }
    
    
}
