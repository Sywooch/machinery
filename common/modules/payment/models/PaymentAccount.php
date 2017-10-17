<?php

namespace common\modules\payment\models;

use yii;

/**
 * This is the model class for table "payment_account".
 *
 * @property integer $id
 * @property integer $balance
 * @property integer $user_id
 * @property integer $account
 */
class PaymentAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balance', 'user_id'], 'integer'],
            [['user_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'balance' => 'Balance',
            'user_id' => 'User ID',
            'account' => 'Account',
        ];
    }
}
