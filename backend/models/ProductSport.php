<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductSport extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_sport';
    }

}
