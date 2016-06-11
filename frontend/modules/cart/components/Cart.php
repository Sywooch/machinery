<?php

namespace frontend\modules\cart\components;

use yii;
use yii\base\Object;
use common\modules\orders\helpers\OrdersHelper;
use common\modules\orders\models\Orders;
use common\modules\orders\models\OrdersItems; 
use common\helpers\ModelHelper;

class Cart extends Object
{
    private $_order;
    
    public function __construct(Orders $order, $config = [])
    {
        $this->_order = $order;
        $this->_order->loadDefaultValues();

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
    public function getOrder($reload = false)
    {
        if($this->_order->id && !$reload){
            return $this->_order;
        }
      
        $order = Orders::find()->where([
                                   'token' => OrdersHelper::getToken(),
                                ])
                                ->orFilterWhere([
                                    'user_id' => Yii::$app->user->id,
                                ])
                                ->andWhere([
                                    'ordered' => 0,
                                ])
                                ->one(); 
        if($order){
            $this->_order = $order;
        }

        return $this->_order;
    }

    private function create(){
        $this->_order->user_id = Yii::$app->user->id;
        $this->_order->token = OrdersHelper::getToken();
        $this->_order->save();
    }


    /**
     * 
     * @param object $entity
     * @return boolean|object
     */
    public function addItem($entity){
        
        $workItem = null;
        
        if($entity === null){
            return;
        }
        
        $this->getOrder();
        
        if(!$this->_order->id){
            $this->create();
        }else{
            foreach($this->_order->ordersItems as $item){
                if($item->entity_id == $entity->id && $item->model == ModelHelper::getModelName($entity)){
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
                'model' => ModelHelper::getModelName($entity),
                'sku' => $entity->sku,
                'title' => $entity->title,
                'price' => $entity->price,
                'entity' => json_encode($entity->attributes)
            ]);
         
        }
        
        if($workItem && $workItem->save()){
            $order = $this->getOrder(true);
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

