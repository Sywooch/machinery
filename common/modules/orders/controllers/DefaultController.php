<?php

namespace common\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use common\modules\orders\models\Orders;
use common\modules\orders\widgets\delivery\DeliveryFactory;
use common\helpers\ModelHelper;
use common\modules\orders\widgets\delivery\helpers\DeliveryHelper;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class DefaultController extends Controller
{
    
    public function actions()
    {
        return [
            'error' => 'yii\web\ErrorAction',
            'load' => 
            [
                'class' => 'common\modules\orders\widgets\delivery\components\LoadAction',
                'order' => Yii::$app->cart->getOrder(),
            ],
        ];
    }
   
    public function actionIndex()
    {
        $order = Yii::$app->cart->getOrder();
        $order->scenario = Orders::SCENARIO_ORDER;
        
        if(!$order->id){
            return $this->redirect(['/cart']);
        }

        if ($order->load(Yii::$app->request->post()) && $order->validate()){
            $delivery = new DeliveryFactory($order->delivery);
            if($delivery->load(Yii::$app->request->post()) && $delivery->validate()){
                $order->deliveryInfo = $delivery;
                $order->save();
                return $this->redirect(['confirm']);
            }
            foreach($delivery->getErrors() as $errors){
                foreach($errors as $error){
                    $order->addError('delivery', $error);
                }
            }
        }
        
        return $this->render('index', [
            'model' => $order
        ]);
    }
    
    public function actionConfirm(){
        $order = Yii::$app->cart->getOrder();

        if(!$order->id){
            return $this->redirect(['/cart']);
        }
        
        if(Yii::$app->request->isPost){
            $order->ordered = true;
            $order->save();
            return $this->redirect(['done']);
        }
        
        $delivery = new DeliveryFactory($order);
        $order->delivery = $delivery->getModel()->getDeliveryName();
        return $this->render('confirm', [
            'model' => $order
        ]);
    }
   
    public function actionDone(){
        return $this->render('done', []);
    }
}
