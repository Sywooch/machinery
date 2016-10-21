<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductBuilding extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_building';
    }
    
}
