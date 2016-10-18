<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductBitovayaIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_bitovaya_index';
    } 
}
