<?php

namespace common\modules\orders\models;

use Yii;
use \yii\db\ActiveRecord;
use common\modules\orders\widgets\delivery\DeliveryFactory;
use common\helpers\ModelHelper;
use common\modules\product\models\PromoCodes;
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
    
    public $_deliveryInfo = [];
    public $_data = [];
    
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
            [['name', 'email', 'phone' , 'address', 'payment', 'delivery'], 'required', 'on' => self::SCENARIO_ORDER],
            [['token'], 'required'],
            [['user_id', 'count', 'created', 'updated', 'ordered'], 'integer'],
            [['price'], 'number'],
            [['comment'], 'string'],
            [['name', 'email', 'phone', 'address', 'payment', 'delivery'], 'string', 'max' => 255],
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
        $scenarios[self::SCENARIO_ORDER] = ['name', 'email', 'phone' , 'address', 'comment', 'payment', 'delivery'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'count' => 'Count',
            'price' => 'Price',
            'name' => 'Имя и Фамилия',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'address' => 'Address',
            'delivery' => 'Доставка',
            'payment' => 'Pay',
            'comment' => 'Comment',
            'created' => 'Created',
            'updated' => 'Updated',
            'ordered' => 'Ordered',
            'token' => 'Token',
        ];
    }
    
    public function beforeSave($insert) {
        $this->price = 0;
        $this->count = 0;
        $this->data = json_encode($this->_data);
        
        foreach($this->items as $item){
            $this->count += $item->count;
            $price = Yii::$app->cart->isPromoItem($item) ? $item->origin->promoPrice : $item->price;
            $this->price += $price * $item->count;
        } 
        return parent::beforeSave($insert);
    }
    
    public function afterFind(){
        $this->_data = json_decode($this->data);
    }

    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
        unset($this->_data->delivery);
        $this->_data = (array)$this->_data;
        $this->_data['delivery'] = $delivery->getData();
    }
    
    public function getDeliveryInfo(){
        return new DeliveryFactory($this->_data->delivery);
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
            'NOT IN', 'model', [ModelHelper::getModelName(PromoCodes::class)]
        ])->with('origin');
    }
    
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id'])->where([
            'model' => ModelHelper::getModelName(PromoCodes::class)
        ])->indexBy('entity_id');
    }
    
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getItem($id)
    {
        return $this->hasOne(OrdersItems::className(), ['order_id' => 'id'])->where(['id' => $id])->one(); 
    }
    
}
