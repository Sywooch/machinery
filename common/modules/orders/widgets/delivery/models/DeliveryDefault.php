<?php
namespace common\modules\orders\widgets\delivery\models;

use yii\base\Model;
use common\modules\orders\widgets\delivery\DeliveryInterface;
use backend\models\ShopAddress;

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
    
    public function getDeliveryName() {
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

