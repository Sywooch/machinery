<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductBitovaya extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_bitovaya';
    }
}
