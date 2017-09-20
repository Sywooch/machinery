<?php
/**
 * Created by PhpStorm.
 * User: befre
 * Date: 10.09.2017
 * Time: 10:15
 */

namespace common\models;

use common\models\OrderPackage;
use common\models\UserPackage;

class UserRepositories extends \common\models\User
{

    /**
     * @param $user_id
     * @param $pack_id
     * @return \common\models\OrderPackage
     * Добавляем юзеру заказ пакета
     */
    public static function saveNewOrder($user_id, $pack_id, $status = 0)
    {
        $package = TarifPackages::findOne($pack_id);
        $order = new OrderPackage();
        $order->user_id = $user_id;
        $order->package_id = $pack_id;
        $order->options = $package->options;
        $order->cost = $package->price;
        $order->status = $status;
        $order->create_at = time();
        $order->save();
        return $order;
    }

    /**
     * @param $user_id
     * @param $options
     * @return \common\models\OrderPackage
     * Добавляем юзеру заказ опций для объявления
     */
    public static function saveOrderOptions($user_id, $options)
    {
        $order = new OrderPackage();
        $order->user_id = $user_id;
//        $order->package_id  = $pack_id;
        $order->options = $options;
//        $order->cost        = $package->price;
        $order->status = TarifPackages::STATUS_ACT;
        $order->create_at = time();
        $order->save();
        return $order;
    }

    /**
     * @param $user_id
     * @param TarifPackages $pack
     * @param \common\models\OrderPackage $order
     * @return int
     *  Добавляем юзеру купленный пакет
     */
    public static function saveActiveOrder($user_id, TarifPackages $pack, OrderPackage $order)
    {
        $user_pac = new UserPackage();
        $user_pac->user_id = $user_id;
        $user_pac->deadline = time() + $pack->term * 24 * 3600;
        $user_pac->date_at = time();
        $user_pac->order_id = $order->id;
        $user_pac->package_id = $pack->id;
        $user_pac->save();
        return $user_pac->id;
    }


}