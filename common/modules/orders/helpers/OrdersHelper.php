<?php

namespace common\modules\orders\helpers;

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
}

