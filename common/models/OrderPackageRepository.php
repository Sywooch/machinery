<?php
/**
 * Created by PhpStorm.
 */

namespace common\models;


class OrderPackageRepository extends OrderPackage
{

    /**
     * @param null $user_id
     * @return array|OrderPackage|null Последний оплаченный заказ пользователя
     */
    public function getOrderActiveByUser($user_id=null){
        $user_id = $user_id ? $user_id : \Yii::$app->user->id;
        return $this::find()->where(['user_id'=>$user_id, 'status' => 1])->one();
    }

    /**
     * @param null $user_id
     * @return array|OrderPackage[] Все оплаченные заказы  пользователя
     */
    public function getOrdersActiveByUser($user_id=null){
        $user_id = $user_id ? $user_id : \Yii::$app->user->id;
        return $this::find()->where(['user_id'=>$user_id, 'status' => 1])->all();
    }

    /**
     * @param null $user_id
     * @return array|OrderPackage|null Последний неоплаченный заказ пользователя
     */
    public function getOrderNotpayByUser($user_id=null){
        $user_id = $user_id ? $user_id : \Yii::$app->user->id;
        return $this::find()->where(['user_id'=>$user_id, 'status' => 0])->one();
    }

    /**
     * @param null $user_id
     * @return array|OrderPackage[] Все неоплаченные заказы пользователя
     */
    public function getOrdersNotpayByUser($user_id=null){
        $user_id = $user_id ? $user_id : \Yii::$app->user->id;
        return $this::find()->where(['user_id'=>$user_id, 'status'=>0])->all();
    }

}