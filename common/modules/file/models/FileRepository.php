<?php

namespace common\modules\file\models;


use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;
use common\modules\file\models\File;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $field
 * @property string $model
 * @property string $filename
 * @property string $path
 * @property string $size
 * @property string $mimetype
 * @property integer $delta
 */
class FileRepository extends File
{

    public function getBatch(array $models, $field = null){
        if(empty($models)){
            return [];
        }
        
        $files =  self::find()
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
}
