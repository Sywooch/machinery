<?php

namespace  common\modules\orders\widgets\delivery\helpers;

use Yii;
use yii\base\InvalidParamException;
use common\helpers\ModelHelper;

class DeliveryHelper
{
    public function getDeliveriesNames(){
        $data = [];
        foreach(Yii::$app->params['orders']['delivery'] as $item){
            $modelName = '\\common\\modules\\orders\\widgets\\delivery\\models\\'.$item;           
            $data[$item] = $modelName::getDeliveryName();
        }
         return $data;
    }
}

