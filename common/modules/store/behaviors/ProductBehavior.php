<?php

namespace common\modules\store\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ProductBehavior extends Behavior
{

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSaveProduct',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSaveProduct',
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function beforeSaveProduct($insert)
    {
        $this->owner->user_id = $this->owner->user_id ? $this->owner->user_id : Yii::$app->user->id;
        $this->owner->index = array_merge([$this->owner->cid], $this->owner->terms);
    }

}

?>