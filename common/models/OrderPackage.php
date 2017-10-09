<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_package}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $package_id
 * @property string $options
 * @property integer $status
 * @property string $cost
 * @property string $create_at
 */
class OrderPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'package_id', 'status', 'advert_id'], 'integer'],
            [['options'], 'string'],
            [['cost'], 'number'],
            [['create_at', 'deadline', 'date_pay'], 'safe'],
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
            'package_id' => Yii::t('app', 'Package ID'),
            'options' => Yii::t('app', 'Options'),
            'status' => Yii::t('app', 'Status'),
            'cost' => Yii::t('app', 'Cost'),
            'create_at' => Yii::t('app', 'Create At'),
            'deadline' => Yii::t('app', 'Deadline'),
            'date_pay' => Yii::t('app', 'Date of payment'),
            'advert_id' => Yii::t('app', 'Advert id'),
        ];
    }

    public function getPackage(){
        return $this->hasOne(TarifPackages::className(), ['id' => 'package_id']);
    }
    /**
     * @inheritdoc
     * @return OrderPackageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderPackageQuery(get_called_class());
    }
}
