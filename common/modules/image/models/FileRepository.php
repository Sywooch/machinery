<?php

namespace common\modules\image\models;

use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;

class FileRepository extends File
{

    /**
     * @param array $models
     * @param null $field
     * @return array
     */
    public function getBatch(array $models, $field = null)
    {
        if (empty($models)) {
            return [];
        }

        $files = self::find()
            ->where([
                'entity_id' => ArrayHelper::getColumn($models, 'id'),
                'model' => ModelHelper::getModelName(array_shift($models))
            ])
            ->andFilterWhere(['field' => $field])
            ->orderBy([
                'delta' => SORT_ASC
            ])
            ->all();

        return ArrayHelper::index($files, null, 'entity_id');
    }

    /**
     * @param int $entityId
     * @return int
     */
    public function count(int $entityId){
        return File::find()
            ->filterWhere(['entity_id' => $entityId])
            ->count();
    }
}
