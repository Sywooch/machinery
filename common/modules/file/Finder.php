<?php

namespace common\modules\file;

use Yii;
use common\modules\file\filestorage\Instance;
use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;
use common\modules\file\filestorage\InstanceInterface;

class Finder{

    /**
     * 
     * @param ActiveRecordInterface $entity
     * @param string $field
     * @return []
     */
    public static function getInstances(ActiveRecordInterface $entity, $field = null){
        return $entity->hasMany(Instance::class, ['entity_id' => 'id'])
                    ->filterWhere([
                        'model' =>  StringHelper::basename(get_class($entity)),
                        'field' => $field,
                    ])
                    ->orderBy([
                        'delta' => SORT_ASC
                    ]);
    }
    
    /**
     * 
     * @param InstanceInterface $instance
     */
    public static function deleteInstance(InstanceInterface $instance){
        $module = Yii::$app->getModule('file');
        array_walk($module->storages, function(&$storage) use($instance){
            $storage->delete($instance);
        }); 
    }
}
