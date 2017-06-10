<?php

namespace common\modules\address\widgets\Field;

use yii;
use yii\base\Widget;
use yii\helpers\StringHelper;
use common\modules\address\models\Address;
use common\modules\address\helpers\AddressHelper;

class AddressField extends Widget {

    public $model;
    public $attribute;
    public $address;
    private static $fieldId = -1;

    public function run() {
        $attribute = $this->attribute;

        if($this->model->{$attribute} && is_array($this->model->{$attribute})){
            $addresses =  Address::findAll($this->model->{$attribute});
            $this->model->{$attribute} = AddressHelper::address($addresses, 'house') ? AddressHelper::address($addresses, 'house') : AddressHelper::address($addresses, 'street');
        }


        self::$fieldId++;
        return $this->render('field', [
            'model' => $this->model,
            'className' => StringHelper::basename(get_class($this->model)),
            'attribute' => $this->attribute,
            'address' => $this->model->{$this->attribute},
            'fieldId' => self::$fieldId
        ]);

    }

}
