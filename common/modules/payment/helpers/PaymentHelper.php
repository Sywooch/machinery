<?php

namespace common\modules\payment\helpers;

class PaymentHelper
{
    /**
     * @param array $accounts
     * @param int $prefix
     * @return bool|mixed
     */
    public static function filterByPrefix(array $accounts, int $prefix)
    {
        foreach ($accounts as $account) {
            if (substr($account->id, 0, strlen($prefix)) == $prefix) {
                return $account;
            }
        }
        return false;
    }
}