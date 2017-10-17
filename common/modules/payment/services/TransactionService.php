<?php

namespace common\modules\payment\services;

use yii;
use common\modules\payment\models\PaymentAccount;
use common\modules\payment\models\PaymentTransaction;

class TransactionService
{

    /**
     * @param PaymentAccount $account
     * @param float $amount
     * @param array $data
     * @return mixed
     */
    public function log(PaymentAccount $account, float $amount, $data = [])
    {
        $transaction = \Yii::createObject([
            'class' => PaymentTransaction::class,
            'accountId' => $account->id,
            'amount' => $amount,
            'data' => $data
        ]);

        return $transaction->save();
    }

}