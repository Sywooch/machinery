<?php

namespace common\modules\payment\models;

use yii;
use yii\db\Expression;

class PaymentAccountRepository
{
    /**
     * @param int $userId
     * @param int $prefix
     * @return array|null|yii\db\ActiveRecord
     */
    public function getAccountByUser(int $userId, int $prefix)
    {
        return PaymentAccount::find()
            ->where(['user_id' => $userId])
            ->andWhere(['LIKE', 'CAST(id AS TEXT)', $prefix])->one();
    }

    /**
     * @param int $userId
     * @return array|yii\db\ActiveRecord[]
     */
    public function getAccountsByUser(int $userId){
        return PaymentAccount::find()
            ->where(['user_id' => $userId])
            ->all();
    }

}
