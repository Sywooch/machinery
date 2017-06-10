<?php

namespace common\modules\address\models;

use yii\db\Expression;

class AddressRepository
{
    /**
     * @param string $address
     * @param int $results
     * @return mixed
     */
    public function trigramSearch(string $address, int $results = 10)
    {
        return Address::find()
            ->select(new Expression('*, similarity(address, :address) as o', ['address' => $address]))->select(new Expression('*, similarity(address, :address) as o', ['address' => $address]))->select(new Expression('*, similarity(address, :address) as o', ['address' => $address]))->select(new Expression('*, similarity(address, :address) as o', ['address' => $address]))
            ->trigram($address)
            ->limit($results)
            ->orderBy(['o' => SORT_DESC])
            ->all();
    }
}