<?php

namespace common\modules\orders\models;

use Yii;
use \yii\db\ActiveRecord;
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
 * @property string $pay
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
            [['user_id', 'count', 'created', 'updated', 'ordered'], 'integer'],
            [['price'], 'number'],
            [['pay', 'delivery', 'comment'], 'string'],
            [['token'], 'required'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 40],
            [['token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \dektrium\user\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
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
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'pay' => 'Pay',
            'delivery' => 'Delivery',
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
        foreach($this->ordersItems as $item){
            $this->count += $item->count;
            $this->price += $item->price * $item->count;
        } 
        return parent::beforeSave($insert);
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
    public function getOrdersItems()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id']);
    }
    
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getItem($id)
    {
        return $this->hasOne(OrdersItems::className(), ['order_id' => 'id'])->where(['id' => $id])->one(); 
    }
    
}
