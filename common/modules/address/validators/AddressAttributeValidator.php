<?php

namespace common\modules\address\validators;

use yii\validators\Validator;

class AddressAttributeValidator extends Validator
{

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @return bool
     */
    public function validateAttribute($model, $attribute)
    {
        $address = $model->{$attribute};
        if (!$address) {
            $this->addError($model, $attribute, 'Address cannot be blank.');
            return false;
        }
    }

}
