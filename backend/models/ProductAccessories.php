<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductAccessories extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_accessories';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        
        $behaviors = parent::behaviors();
        $behaviors[0] = [
                    'class' => \common\modules\taxonomy\components\TaxonomyBehavior::class,
                    'indexModel' => \backend\models\ProductAccessoriesIndex::class
                ];
        return $behaviors;
    }
}
