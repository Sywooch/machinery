<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductSportIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_sport_index';
    } 
}
