<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductHardware extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_hardware';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        
        $behaviors = parent::behaviors();
        $behaviors[0] = [
                    'class' => \common\modules\taxonomy\components\TaxonomyBehavior::class,
                    'indexModel' => \backend\models\ProductHardwareIndex::class
                ];
        return $behaviors;
    }
}
