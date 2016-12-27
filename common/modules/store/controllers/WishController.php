<?php
namespace common\modules\store\controllers;

use Yii;
use yii\helpers\StringHelper;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\store\models\wish\Wishlist;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\modules\store\Finder;

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
            $modelClass = '\\common\\modules\\store\\models\\product\\' . $model;
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
          
        $model = '\\common\\modules\\store\\models\\product\\' . Yii::$app->request->post('model');
        $finder = Yii::$container->get(Finder::class, [new $model]);
        
        if(!($entity = $finder->getProductById(Yii::$app->request->post('id')))){
            throw new InvalidParamException();
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
