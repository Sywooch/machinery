<?php

namespace backend\models;

use backend\models\ProductDefault;


class ProductAV extends ProductDefault
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_av';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        
        $behaviors = parent::behaviors();
        $behaviors[0] = [
                    'class' => \common\modules\taxonomy\components\TaxonomyBehavior::class,
                    'indexModel' => \backend\models\ProductAVIndex::class
                ];
        return $behaviors;
    }
}
