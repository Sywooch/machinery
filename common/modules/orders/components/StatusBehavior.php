<?php

namespace common\modules\orders\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\orders\models\Status;
use common\helpers\ModelHelper;

class StatusBehavior extends Behavior
{
    public $statuses;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'afterDelete',
        ];
    }
    
    public function afterDelete(){
        Status::deleteAll(['entity_id' => $this->owner->id,'model' => ModelHelper::getModelName($this->owner)]);
    }

}

?>