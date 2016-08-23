<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
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
class AliasRepository extends ActiveRecord
{
    
    public function getBatch(array $models){
         if(empty($models)){
            return [];
        }
        
        return  Alias::find()
                ->where([
                    'entity_id' => ArrayHelper::getColumn($models, 'id'),
                    'model' => ModelHelper::getModelName(array_shift($models))
                ])
                ->indexBy('entity_id')
                ->all();
    }
    
    /**
     * 
     * @param Alias $model
     * @return boolean
     */
    public function saveGroup(Alias $model){
        if(!$model->groupAlias){
            return false;
        }
        
        $alias = Alias::find()->where([
            'model' => Alias::GROUP_MODEL,
            'alias' => $model->groupAlias
        ])->one();
        
        if(!$alias){
            $alias = \Yii::createObject([
                'class' => Alias::class,
                'entity_id' => $model->groupId,
                'url' => $model->groupUrl,
                'alias' => $model->groupAlias,
                'model' => Alias::GROUP_MODEL,
            ]);
            $alias->detachBehaviors();
            $alias->save();
        }
        
        return true;
    }
}
