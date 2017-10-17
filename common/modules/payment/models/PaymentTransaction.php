<?php

namespace common\modules\payment\models;

use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_transaction".
 *
 * @property integer $id
 * @property integer $date
 * @property integer $accountId
 * @property integer $extraAccountId
 * @property integer $amount
 * @property string $data
 */
class PaymentTransaction extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accountId'], 'required'],
            [['accountId', 'extraAccountId', 'amount'], 'integer'],
            [['data'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'accountId' => 'Account ID',
            'extraAccountId' => 'Extra Account ID',
            'amount' => 'Amount',
            'data' => 'Data',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
                ]
            ]
        ];
    }
}
