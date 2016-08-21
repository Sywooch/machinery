<?php

namespace common\models;

use Yii;
use common\models\Alias;
use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;

/**
 * This is the model class for table "alias".
 *
 * @property integer $id
 * @property string $url
 * @property string $alias
 * @property string $model
 */
class AliasRepository extends Alias
{
    
    public function getBatch(array $models){
         if(empty($models)){
            return [];
        }
        
        return  self::find()
                ->where([
                    'entity_id' => ArrayHelper::getColumn($models, 'id'),
                    'model' => ModelHelper::getModelName(array_shift($models))
                ])
                ->indexBy('entity_id')
                ->all();
    }
}
