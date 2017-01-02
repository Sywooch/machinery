<?php

namespace common\modules\store\components;

use Yii;
use yii\helpers\StringHelper;
use yii\base\Object;
use common\modules\store\helpers\OrdersHelper;
use common\modules\store\models\order\Orders;
use common\modules\store\models\order\OrdersItems; 
use common\modules\store\models\order\OrderItemInterface;

class Cart extends Object
{
    
    private $_order;
    
    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
        $this->init();
    }
    
    /**
     * 
     * @param boolean $reload
     * @return null|object
     */
    public function getOrder($token = false)
    {
        if($this->_order && $token === false){
            return $this->_order;
        }
        $this->_order = Orders::find()->where([
                                   'token' => $token ? $token : OrdersHelper::getToken(),
                                ])
                                ->orFilterWhere([
                                    'user_id' => Yii::$app->user->id,
                                ])
                                ->andWhere([
                                    'ordered' => 0,
                                ])
                                ->one(); 
        return $this->_order;
    }

    private function create(){
        $this->_order = new Orders();
        $this->_order->user_id = Yii::$app->user->id;
        $this->_order->token = OrdersHelper::getToken(true);
        $this->_order->save();
    }


    /**
     * 
     * @param ProductBase $entity
     * @return boolean|object
     */
    public function addItem(OrderItemInterface $entity){
        
        $workItem = null;
        
        if($entity === null){
            return;
        }

        $this->getOrder();
        
        if(!$this->_order){
            $this->create();
        }else{
            foreach($this->_order->items as $item){
                if($item->entity_id == $entity->id && $item->model == StringHelper::basename(get_class($entity))){
                    $workItem = $item;
                    $workItem->count++;
                    continue;
                }
            }  
        }
        
        if($workItem === null){
           $workItem = \Yii::createObject([
                'class' => OrdersItems::class,
                'order_id' => $this->_order->id,
                'entity_id' => $entity->id,
                'model' => StringHelper::basename(get_class($entity)),
                'sku' => $entity->sku,
                'title' => $entity->title,
                'price' => $entity->price,
                'entity' => json_encode($entity->attributes)
            ]);
        }
        
        if($workItem && $workItem->save()){
            $order = $this->getOrder($this->_order->token);
            $order->save();
            return $order;
        }
        return false;
    }
    
    /**
     * 
     * @param int $id
     * @return boolean|object
     */
    public function removeItem($id){
        
        if(($order = $this->getOrder()) === null){
            return null;
        }
        if(($item = $order->getItem($id)) !== null && $item->delete()){
            $order = $this->getOrder(null);
            $order->save();
            return $order;
        }
        return false;
    }
    
    /**
     * 
     * @param int $id
     * @param int $count
     * @return boolean
     */
    public function countItem($id, $count){

        if(($order = $this->getOrder()) === null){
            return null;
        }
        if(($item = $order->getItem($id)) === null){
            return null;
        }
        $item->count = $count;
        if($item->save() && $order->save()){
            return $order;
        }
        return null;
    }
     
}

