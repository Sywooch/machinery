<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductSport extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_sport';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        
        $behaviors = parent::behaviors();
        $behaviors[0] = [
                    'class' => \common\modules\taxonomy\components\TaxonomyBehavior::class,
                    'indexModel' => \backend\models\ProductSportIndex::class
                ];
        return $behaviors;
    }
}
