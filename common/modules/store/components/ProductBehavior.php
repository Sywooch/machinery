<?php

namespace common\modules\store\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\store\helpers\ProductHelper;

class ProductBehavior extends Behavior
{
    private $_helper;
    
    public function __construct(ProductHelper $helper, $config = array()) {
        $this->_helper = $helper;
        parent::__construct($config);
    }
    
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
        $this->owner->helper = $this->_helper;
        parent::init();
    }

    /**
     * 
     * @inheritdoc
     */
    public function beforeSaveProduct($insert) {
        $this->owner->group = ProductHelper::createGroup($this->owner->attributes);
        $this->owner->user_id = $this->owner->user_id ? $this->owner->user_id : Yii::$app->user->id;
        $this->owner->index = array_merge($this->owner->catalog, $this->owner->terms);
    }
    
}

?>