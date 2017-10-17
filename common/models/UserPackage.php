<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_package".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date_at
 * @property integer $package_id
 * @property integer $order_id
 * @property string $deadline
 *
 * @property TarifPackages $package
 * @property User $user
 */
class UserPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'package_id', 'order_id'], 'integer'],
            [['date_at', 'deadline', 'order_id'], 'safe'],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => TarifPackages::className(), 'targetAttribute' => ['package_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'date_at' => Yii::t('app', 'Date At'),
            'package_id' => Yii::t('app', 'Package ID'),
            'deadline' => Yii::t('app', 'Deadline'),
            'order_id' => Yii::t('app', 'Order ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(TarifPackages::className(), ['id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(OrderPackage::className(), ['id' => 'order_id']);
    }

    /**
     * @inheritdoc
     * @return UserPackageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserPackageQuery(get_called_class());
    }
}
