<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductAutoIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_auto_index';
    } 
}
