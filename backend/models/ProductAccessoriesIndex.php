<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductAccessoriesIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_accessories_index';
    } 
}
