<?php

namespace common\modules\orders\widgets\delivery;

use yii;
use yii\base\Widget;
use yii\base\InvalidParamException;
use common\modules\orders\widgets\delivery\DeliveryFactory;

class Delivery extends Widget {

    public $model, $attribute;
    public $form;
    
    public function init() {
        parent::init();
    }

    public function run() {
        
        if(!$this->model->delivery){
            $this->model->delivery = 'DeliveryDefault';
        }
        return $this->render('field', [
                        'model' => $this->model,
                        'delivery' => new DeliveryFactory($this->model),
                        'form' => $this->form
        ]);
    }

}
