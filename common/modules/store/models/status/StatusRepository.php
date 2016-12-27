<?php

namespace common\modules\store\models\status;

use Yii;
use yii\base\Object;
use common\modules\store\models\status\Status;

class StatusRepository extends Object
{
    public function getLastStatus($entity_id, $model) {
        return Status::find()
                ->where([
                    'entity_id' => $entity_id,
                    'model' => $model,
                ])
                ->orderBy(['updated_at' => SORT_DESC])
                ->limit(1)
                ->one();
    }
    
    public static function countStatus($statuses, $model) {
        return (new \yii\db\Query())
                        ->select('COUNT(id)')
                        ->from($model::tableName())
                        ->where([
                            'status' => $statuses,
                            'ordered' => 1
                        ])->scalar();
    }
}
