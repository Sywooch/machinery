<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductAV extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_av';
    }
    
}
