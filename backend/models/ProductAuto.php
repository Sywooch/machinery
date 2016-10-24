<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductAuto extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_auto';
    }

}
