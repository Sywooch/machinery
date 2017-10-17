<?php

namespace common\modules\payment\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


class InvoiceRepository
{

    /**
     * @param string $uuid
     * @return static
     */
    public function getInvoiceByUuid(string $uuid){
        return Invoice::findOne(['uuid' => $uuid]);
    }

    /**
     * @param string $id
     * @return static
     */
    public function getInvoiceById(string $id){
        return Invoice::findOne($id);
    }

}
