<?php

namespace common\modules\payment\models;

use yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $mail
 * @property string $name
 * @property integer $balance
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 */
class InvoiceBace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'status'], 'integer'],
            [['amount'], 'double'],
            [['account_id', 'amount'], 'required'],
            [['message','uuid'], 'string', 'max' => 255],
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
            'mail' => 'Mail',
            'name' => 'Name',
            'balance' => 'Balance',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

}
