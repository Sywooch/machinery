<?php

namespace common\modules\address\helpers;

use yii\base\Model;
use common\modules\address\validators\AddressAttributeValidator;
use common\modules\address\models\Address;

class AddressHelper {


    /**
     * @param array $addresses
     * @param string $type
     * @return string
     */
    public static function toString(array $addresses, string $type)
    {
        $address = self::address($addresses, $type);

        if ($address) {
            return $address->name;
        }
        return '';
    }
    
    /**
     * @param Model $model
     * @return array
     */
    public static function getAddressAttributes(Model $model){
        $fields = [];
        $rules = $model->rules();
        foreach($rules as $rule){
            $field = array_shift($rule);
            $type = current($rule);
            if($type == AddressAttributeValidator::class){
                $fieldsTmp = [];
                if(is_array($field)){
                    $fieldsTmp = $field;
                }else{
                    $fieldsTmp[] = $field;
                }

                foreach($fieldsTmp as $field){
                    $fields[$field] = array_merge([$field], $rule);
                }
            }  
        }
        return $fields;
    }

    /**
     * @param Address $address
     * @return string
     */
    public static function getCoordinates(Address $address){
        return implode(',', [(string)$address->latitude, (string)$address->longitude]);
    }


    /**
     * @param array $addresses
     * @param string $type
     * @return Address|bool
     */
    public static function address(array $addresses, string $type){
        foreach($addresses as $address){
            if($address->type == $type){
                return $address;
            }
        }
        return false;
    }

    /**
     * @param array $addresses
     * @param null $type
     * @return array|mixed
     */
    public static function chain(array $addresses, $type = null){

        $types = ['house','street','district','locality','province','country'];

        if($type){
            $types = array_slice ( $types, array_search($type, $types) );
        }

        foreach ($types as $type){
            foreach ($addresses as $address){
                if($address->type == $type){
                    return $address;
                }
            }
        }
        return [];
    }

}
