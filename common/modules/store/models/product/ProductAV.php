<?php

namespace common\modules\store\models\product;

use common\modules\store\models\ProductBase;

class ProductAV extends ProductBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_av';
    }
    
}
