<?php

namespace common\modules\payment\services;

use common\modules\payment\models\PaymentAccount;
use common\modules\payment\models\PaymentAccountRepository;
use yii\web\IdentityInterface;

class AccountService
{

    const DEFAULT_ACCOUNT_PREFIX = 1020;

    /**
     * @var PaymentAccountRepository
     */
    protected $paymentAccountRepository;

    /**
     * AccountService constructor.
     * @param PaymentAccountRepository $paymentAccountRepository
     */
    function __construct(PaymentAccountRepository $paymentAccountRepository)
    {
        $this->paymentAccountRepository = $paymentAccountRepository;
    }

    /**
     * @param IdentityInterface $user
     * @param int $count
     * @param int $prefix
     * @return array
     */
    public function createAccounts(IdentityInterface $user, int $count = 1, int $prefix = self::DEFAULT_ACCOUNT_PREFIX)
    {
        $accounts = [];
        $account = mt_rand(100000000000, 999999999999);

        for ($i = $prefix; $i < $prefix + $count; $i++) {
            $accounts[] = $this->createAccount($user, str_pad($i . $account, 18, 0));
        }

        return $accounts;
    }

    /**
     * @param IdentityInterface $user
     * @param int $accountId
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function createAccount(IdentityInterface $user, int $accountId)
    {
        $account = \Yii::createObject([
            'class' => PaymentAccount::class,
            'id' => $accountId,
            'user_id' => $user->id
        ]);

        $account->save();
        return $account;
    }

    /**
     * @param IdentityInterface $user
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAccountUserAccounts(IdentityInterface $user)
    {
        return $this->paymentAccountRepository->getAccountsByUser($user->id);
    }

    /**
     * @param IdentityInterface $user
     * @param int $prefix
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getUserAccount(IdentityInterface $user, int $prefix = self::DEFAULT_ACCOUNT_PREFIX)
    {
        return $this->paymentAccountRepository->getAccountByUser($user->id, $prefix);
    }

    /**
     * @param PaymentAccount $account
     * @param float $amount
     * @return bool
     */
    public function increase(PaymentAccount $account, float $amount)
    {
        $account->balance += $amount;
        return $account->save();
    }

    /**
     * @param PaymentAccount $account
     * @param float $amount
     * @return bool
     */
    public function decrease(PaymentAccount $account, float $amount)
    {
        $account->balance -= $amount;
        return $account->save();
    }

}