<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductHardware extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_hardware';
    }

}
