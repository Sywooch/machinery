<?php

namespace common\modules\store\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\orders\models\Status;
use yii\helpers\StringHelper;

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
        Status::deleteAll(['entity_id' => $this->owner->id,'model' => StringHelper::basename(get_class($this->owner))]);
    }

}

?>