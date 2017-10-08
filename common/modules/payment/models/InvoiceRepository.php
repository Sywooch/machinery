<?php

namespace common\modules\payment\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


class InvoiceRepository
{

    /**
     * @param int $id
     * @return static
     */
    public function getInvoceById(int $id){
        return Invoice::findOne($id);
    }

}
