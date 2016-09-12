<?php

namespace common\modules\orders\models;

use Yii;

/**
 * This is the model class for table "orders_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $entity_id
 * @property string $model
 * @property string $sku
 * @property string $title
 * @property double $price
 * @property integer $count
 * @property string $entity
 *
 * @property Orders $order
 */
class OrdersItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'entity_id', 'model', 'sku', 'title'], 'required'],
            [['order_id', 'entity_id', 'count'], 'integer'],
            [['price'], 'number'],
            [['entity'], 'string'],
            [['model'], 'string', 'max' => 50],
            [['sku'], 'string', 'max' => 40],
            [['title'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'entity_id' => 'Entity ID',
            'model' => 'Model',
            'sku' => 'Sku',
            'title' => 'Title',
            'price' => 'Price',
            'count' => 'Count',
            'entity' => 'Entity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }
    
    /** 
     * @return \yii\db\ActiveQuery
     */
    public function getOrigin()
    {        
        $model = '\\backend\\models\\' . $this->model;
        return $this->hasOne($model, ['id' => 'entity_id'])->with(['promoCode']);
    }
    
    public function getData(){
        return json_decode($this->entity);
    }
}
