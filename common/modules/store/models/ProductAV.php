<?php

namespace common\modules\store\models;

use common\modules\store\models\ProductDefault;

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
