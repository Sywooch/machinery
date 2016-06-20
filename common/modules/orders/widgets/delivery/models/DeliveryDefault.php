<?php
namespace common\modules\orders\widgets\delivery\models;

use yii\base\Model;
use common\modules\orders\widgets\delivery\DeliveryInterface;

class DeliveryDefault extends Model implements DeliveryInterface{

    public $address;
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address' => 'Адрес'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address'], 'required'],
            [['address'], 'string', 'max' => 255],
           
        ];
    }
    
    public function getDeliveryName() {
        return 'Самовывоз';
    }
    
    public function getAdderessList(){
        return [
            'Киевская 7б' => 'Киевская 7б'
        ];
    }
}

