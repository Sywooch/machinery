<?php
namespace common\modules\store\controllers;

use Yii;
use yii\helpers\StringHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\store\models\wish\Wishlist;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\modules\store\Finder;
use common\modules\store\helpers\ProductHelper;

/**
 * Site controller
 */
class WishController extends Controller
{

    
    public function actionIndex($userId){
        $user = User::findOne($userId);
        
        if(!$user){
            throw new NotFoundHttpException('Страница не найдена.');
        }
        
        $finder = Yii::$container->get(Finder::class);
        
        if(empty($wishList = $finder->getWishItems(Yii::$app->user->identity))){
           return $this->render('_empty', ['user' => $user]);
        }

        $entityIds = ArrayHelper::map($wishList, 'entity_id', 'entity_id', 'model');
        $models = [];
        foreach($entityIds as $model => $ids){
            $modelClass = ProductHelper::getClass($model);
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
          
        $model = ProductHelper::getModel(Yii::$app->request->post('model'));
        
        if(!$model){
            throw new BadRequestHttpException();
        }
        
        $finder = Yii::$container->get(Finder::class, [$model]);
        
        if(!($entity = $finder->getProductById(Yii::$app->request->post('id')))){
            throw new BadRequestHttpException();
        }

        if($finder->wishSearch->count > $finder->module->maxItemsToWish){
            return [
                'status' => 'error', 
                'message' => 'Добавлено максимальное количество продуктов в избранном.'
            ];
        }

        if(!($wish = $entity->wish)){
            $wish = Yii::createObject([
                'class' => Wishlist::class,
                'user_id' => Yii::$app->user->id,
                'entity_id' => $entity->id,
                'model' => StringHelper::basename($entity::className())
            ]);
            $wish->save();
        }else{
            $wish->delete();
        }
        
        return [
                'status' => 'success', 
                'action' => $wish->isNewRecord ? 'deleted' : 'added' ,
                'id' => $wish->entity_id,
                'model' => $wish->model,
                'count' => $finder->wishSearch->count
            ];
    }
    
    
}
