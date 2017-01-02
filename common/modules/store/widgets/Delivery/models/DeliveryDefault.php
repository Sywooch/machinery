<?php
namespace common\modules\store\widgets\Delivery\models;

use yii\base\Model;
use common\modules\store\widgets\Delivery\models\DeliveryInterface;
use common\modules\store\models\address\ShopAddress;

class DeliveryDefault extends Model implements DeliveryInterface{

    public $address;
    public $date;
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address' => 'Адрес',
            'date' => 'Мне удобно получить заказ'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address'], 'required'],
            [['address','date'], 'string', 'max' => 255],
           
        ];
    }
    
    public static function getDeliveryName() {
        return 'Самовывоз';
    }
    
    public function init(){
        if(!$this->address){
            $this->address = ShopAddress::find()->one()->address;
        }
    }


    public function getAdderessList(){
        
        $models = ShopAddress::find()->all();
        
    }
}

