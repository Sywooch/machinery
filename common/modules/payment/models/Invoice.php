<?php

namespace common\modules\payment\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


class Invoice extends InvoiceBace
{
    const STATUS_FAIL = 0;
    const STATUS_PENDING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ACCEPTED = 3;
    const STATUS_COMPLETE = 4;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
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
    public function getAccount()
    {
        return $this->hasOne(PaymentAccount::class, ['id' => 'account_id']);
    }

}
