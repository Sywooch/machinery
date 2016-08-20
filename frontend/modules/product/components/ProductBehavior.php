<?php

namespace frontend\modules\product\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use frontend\modules\product\helpers\ProductHelper;
use frontend\modules\product\models\ProductCharacteristics;

class ProductBehavior extends Behavior
{
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSaveProduct',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSaveProduct'
        ];
    }
    
    /** @inheritdoc */
    public function afterSaveProduct($insert) {
        
       
      
    }
}

?>