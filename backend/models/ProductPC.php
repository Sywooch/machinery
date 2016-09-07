<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductPC extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_pc';
    }
}
