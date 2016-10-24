<?php

namespace common\modules\product\components;

use Yii;
use common\modules\product\helpers\ProductHelper;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\product\models\ProductIndex;

class ProductBehavior extends Behavior
{
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSaveProduct',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSaveProduct',
            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }
    
    /**
     * 
     * @inheritdoc
     */
    public function afterInit(){
        $this->owner->indexModel = new ProductIndex($this->owner);
        parent::init();
    }

    /**
     * 
     * @inheritdoc
     */
    public function beforeSaveProduct($insert) {
        $this->owner->group = ProductHelper::createGroup($this->owner->attributes);
        $this->owner->user_id = $this->owner->user_id ? $this->owner->user_id : Yii::$app->user->id;
    }
    
}

?>