<?php
namespace common\modules\store\helpers;

use common\modules\store\models\order\Orders;
use common\modules\store\models\order\OrdersItems;
use common\modules\store\models\promo\PromoCodes;

use Yii;
class OrdersHelper
{
    /**
     * 
     * @return string
     */
    public static function getToken($reload = false){
        $token = Yii::$app->request->cookies['order_token'];
        if (!$token || $reload === true) {
            $token = md5(rand(0,999999) . time());
            Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'order_token','value' => $token]));
            return $token;
        }
        if(isset($token->value)){
            return $token->value;
        }
        return '';
    }
    
    /**
     * 
     * @param OrdersItems $item
     * @return boolean
     */
    public static function isPromo(Orders $order, OrdersItems $item){
        if($item->sku != PromoCodes::PROMO_CODE && isset($item->origin->promoCode) && isset($order->promo[$item->origin->promoCode->id])){
            return true;
        }
        return false;
    }
}

