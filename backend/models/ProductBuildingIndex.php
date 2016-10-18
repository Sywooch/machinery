<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductBuildingIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_building_index';
    } 
}
