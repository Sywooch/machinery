<?php

namespace common\modules\store\models\order;

use \yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use common\modules\store\widgets\delivery\DeliveryFactory;
use common\modules\store\models\promo\PromoCodes;
use common\models\User;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $count
 * @property double $price
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $payment
 * @property string $delivery
 * @property string $comment
 * @property integer $created
 * @property integer $updated
 * @property integer $ordered
 * @property string $token
 *
 * @property User $user
 * @property OrdersItems[] $ordersItems
 */
class Orders extends ActiveRecord
{
    
    const SCENARIO_ORDER = 'order';
    const SCENARIO_PAYMENT = 'payment';

    public $_deliveryInfo = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'delivery', 'status'], 'required', 'on' => self::SCENARIO_ORDER],
            [['payment'], 'required', 'on' => self::SCENARIO_PAYMENT],
            [['token'], 'required'],
            [['user_id', 'count', 'created', 'updated', 'ordered'], 'integer'],
            [['price'], 'number'],
            [['comment'], 'string'],
            [['name', 'email', 'phone', 'phone2', 'address', 'payment', 'delivery'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 40],
            [['token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \dektrium\user\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ORDER] = ['name',  'phone' ,  'delivery'];
        $scenarios[self::SCENARIO_ORDER] = ['payment'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ заказа',
            'user_id' => 'User ID',
            'count' => 'Count',
            'price' => 'Price',
            'name' => 'Фио',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'phone2' => 'Телефон, если не дозвонимся',
            'address' => 'Address',
            'delivery' => 'Доставка',
            'payment' => 'Pay',
            'comment' => 'Комментарий',
            'created' => 'Created',
            'updated' => 'Updated',
            'ordered' => 'Ordered',
            'token' => 'Token',
        ];
    }
    
    public function beforeSave($insert) {
        
        $this->data = json_encode($this->data);
        
        if($this->scenario != 'default'){
            return parent::beforeSave($insert);
        }
        
        $this->price = 0;
        $this->count = 0;
        
        foreach($this->items as $item){
            $this->count += $item->count;
            $this->price += $item->price * $item->count;
        } 
        return parent::beforeSave($insert);
    }
    
    public function afterFind(){
        $this->data = json_decode($this->data);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => \common\modules\store\components\StatusBehavior::class,
                    'statuses' => [
                            0 => 'Не оформлен',
                            1 => 'Новый',
                            2 => 'В обработке',
                            3 => 'Ожидает оплаты',
                            4 => 'Оплачен',
                            5 => 'Ожидает доставки',
                            6 => 'Передан в доставку',
                            7 => 'Отменен',
                            8 => 'Завершен',
                    ]
                ],
                [
                    'class' => \yii\behaviors\TimestampBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                    ]
                ]
            ];
    }

    public function setDeliveryInfo(DeliveryFactory $delivery){
        $data = (array)$this->data;
        $data['delivery'] = $delivery->getData();
        $this->data = $data;
    }
    
    public function getDeliveryInfo(){
        return new DeliveryFactory($this->data->delivery);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id'])->where([
            'NOT IN', 'model', [StringHelper::basename(PromoCodes::class)]
        ])->with('origin');
    }
    
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id'])->where([
            'model' => StringHelper::basename(PromoCodes::class)
        ])->indexBy('entity_id');
    }
    
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getItem($id)
    {
        return $this->hasOne(OrdersItems::className(), ['order_id' => 'id'])->where(['id' => $id])->one(); 
    }
        
    public function getPaymentList(){
        // TODO: Сделать систему оплат
        return [
            'Default' => 'Наличными при получении',
            'Card' => 'Банковской картой (онлайн)',
            'Webmoney' => 'WebMoney (комиссия +2.5%)'
        ];
    }
    
}
