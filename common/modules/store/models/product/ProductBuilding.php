<?php

namespace common\modules\store\models\product;

use common\modules\store\models\ProductBase;

class ProductBuilding extends ProductBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_building';
    }
    
}
