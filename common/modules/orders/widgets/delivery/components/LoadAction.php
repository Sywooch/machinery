<?php
namespace common\modules\orders\widgets\delivery\components;

use yii\base\Action;
use common\modules\orders\widgets\delivery\DeliveryFactory;
use common\helpers\ModelHelper;

class LoadAction extends Action
{
    public $order;
    public function run($name)
    {
        $delivery = new DeliveryFactory($this->order);
        if(ModelHelper::getModelName($delivery->getModel()) != $name){
            $delivery = new DeliveryFactory($name);
        }
 
        return $this->controller->renderPartial('../../widgets/delivery/views/'.ModelHelper::getModelName($delivery->getModel()), [
                'model' => $delivery->getModel(),
            ]);
    }
}