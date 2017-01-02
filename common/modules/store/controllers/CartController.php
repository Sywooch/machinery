<?php

namespace common\modules\store\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use common\modules\store\widgets\delivery\DeliveryFactory;
use common\modules\store\models\order\Orders;
use common\modules\store\helpers\ProductHelper;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class CartController extends Controller
{
    /**
     * Lists all TaxonomyItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->request->isPost){
            return $this->redirect(['/store/cart/order']);
        }
        
        return $this->render('index', [
                    'cart' => Yii::$app->cart            
        ]);
    }
    
    public function actionOrder(){
        
        $order = Yii::$app->cart->getOrder();
        
        if(!$order){
            return $this->redirect(['/store/cart']);
        }
        
        $order->scenario = Orders::SCENARIO_ORDER;
        
        if(!$order->id){
            return $this->redirect(['/cart']);
        }
        
        if(Yii::$app->user->id && !$order->name){
            $order->name = Yii::$app->user->identity->profile->name;
            $order->phone = Yii::$app->user->identity->profile->phone;
            $order->email = Yii::$app->user->identity->email;
        }

        if ($order->load(Yii::$app->request->post()) && $order->validate()){
            $delivery = new DeliveryFactory($order->delivery);
            if($delivery->load(Yii::$app->request->post()) && $delivery->validate()){
                $order->deliveryInfo = $delivery;
                $order->save();
                return $this->redirect(['/store/cart/payment']);
            }
            foreach($delivery->getErrors() as $errors){
                foreach($errors as $error){
                    $order->addError('delivery', $error);
                }
            }
        }
        
        return $this->render('order', [
            'model' => $order
        ]);
    }
    public function actionPayment(){
        $order = Yii::$app->cart->getOrder();
         $order->scenario = Orders::SCENARIO_PAYMENT;
        if(!$order->id){
            return $this->redirect(['/cart']);
        }
        if(!$order->payment){
           $order->payment = 'Default'; 
        }
        if ($order->load(Yii::$app->request->post()) && $order->validate()){
            $order->save();
            return $this->redirect(['/store/cart/confirm']);
        }
        return $this->render('payment', [
            'model' => $order
        ]);
    }
    public function actionConfirm(){
        $order = Yii::$app->cart->getOrder();

        if(!$order->id){
            return $this->redirect(['/cart']);
        }
       
        if ($order->load(Yii::$app->request->post()) && $order->validate()){
            $order->ordered = true;
            
            $order->save();
            return $this->redirect(['/store/cart/done']);
        }
        
        return $this->render('confirm', [
            'model' => $order,
            'cart' => Yii::$app->cart,    
        ]);
    }
   
    public function actionDone(){
        return $this->render('done', []);
    }

    public function actionAdd($entityId, $model){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $model = ProductHelper::getClass($model);
        
        if(!$model){
            throw new BadRequestHttpException();
        }
        
        $product = $model::findOne($entityId);
        
        if(!$product){
            throw new BadRequestHttpException();
        }
        Yii::$app->cart->addItem($product);
        $order = Yii::$app->cart->getOrder();
        return [
                'success' => 'true',
                'order' => Yii::$app->cart->getOrder(),
                'product' => $product,
                'formaters' => [
                    'items' => Yii::t('app', '{n, plural, =0{Корзина} one{# товар} few{# товара} many{# товаров} other{# товаров}}', array(
                        'n' => $order->count 
                    )),
                    'total' => Yii::$app->formatter->asCurrency($order->price)
                ]
        ];
    }
    
    public function actionCount($id, $count){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(($order = Yii::$app->cart->countItem($id, $count)) === null){
            throw new BadRequestHttpException();
        }
        $product = $order->getItem($id);
        return [
                'success' => 'true',
                'order' => $order,
                'item' => $product,
                'formaters' => [
                    'items' => Yii::t('app', '{n, plural, =0{Корзина} one{# товар} few{# товара} many{# товаров} other{# товаров}}', array(
                        'n' => $order->count 
                    )),
                    'total' => Yii::$app->formatter->asCurrency($order->price),
                    'itemTotal' => Yii::$app->formatter->asCurrency($product->price * $product->count),
                    'itemRealTotal' => Yii::$app->formatter->asCurrency($product->origin->price * $product->count)
                ]
        ];
    }
    
    public function actionRemove(array $id){
        foreach($id as $itemId){
          Yii::$app->cart->removeItem($itemId); 
        }
        return $this->redirect(['/store/cart']);
    }
}
