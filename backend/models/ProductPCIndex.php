<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductPCIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_pc_index';
    } 
}
