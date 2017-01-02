<?php

namespace  common\modules\store\widgets\Delivery\helpers;

use Yii;
use backend\models\ShopAddress;

class DeliveryHelper
{
    public static function getDeliveriesNames(){
        $data = [];
        foreach(Yii::$app->params['orders']['delivery'] as $item){
            $modelName = '\\common\\modules\\store\\widgets\\delivery\\models\\'.$item;           
            $data[$item] = $modelName::getDeliveryName();
        }
         return $data;
    }
    
    /**
     * 
     * @param array $address
     * @return string
     */
    public static function getAddress(array $address){
        $return = [];
        foreach($address as $model){
           $return[$model->address] =  $model->title.' <span class="address"> '.$model->address.'</span><span class="work-time">'.$model->work_time.'</span>';
        }
        return $return;
    }
    
    
    public static function getReceiveDates(){
        $return = [];
        for($i=1;$i<=3;$i++){
            $time = strtotime("now +{$i} day");
            $date = Yii::$app->formatter->asDate($time, 'd MMMM yyyy');
            $return[$date] = $date;
        }
        return $return;
    }
    
    
}

