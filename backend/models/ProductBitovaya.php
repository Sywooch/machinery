<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductBitovaya extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_bitovaya';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        
        $behaviors = parent::behaviors();
        $behaviors[0] = [
                    'class' => \common\modules\taxonomy\components\TaxonomyBehavior::class,
                    'indexModel' => \backend\models\ProductBitovayaIndex::class
                ];
        return $behaviors;
    }
}
