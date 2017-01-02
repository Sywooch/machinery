<?php
namespace common\modules\store\widgets\Delivery\models;

use yii\base\Model;
use common\modules\store\widgets\Delivery\models\DeliveryInterface;

class DeliveryNovaPochta extends Model implements DeliveryInterface{
    
    
    public $name;
    public $address;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
           
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'address' => 'Адрес'
        ];
    }
    
    public function getDeliveryName() {
        return 'Новая почта';
    }
}

