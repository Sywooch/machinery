<?php

namespace backend\models;

use backend\models\ProductDefaultIndex;


class ProductAVIndex extends ProductDefaultIndex
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_av_index';
    } 
}
