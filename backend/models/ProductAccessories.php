<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductAccessories extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_accessories';
    }
    
}