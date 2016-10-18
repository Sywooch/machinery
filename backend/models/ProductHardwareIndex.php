<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductHardwareIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_hardware_index';
    } 
}
