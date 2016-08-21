<?php

namespace common\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Alias;
use common\helpers\ModelHelper;
use \common\helpers\URLify;

class UrlBehavior extends Behavior
{
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    
    public function getAlias(){
        return $this->owner->hasOne(Alias::className(), ['entity_id' => 'id'])->where(['model' => ModelHelper::getModelName($this->owner)]);
    }
    public function getGroupAlias(){
        return $this->owner->hasOne(Alias::className(), ['entity_id' => 'group'])->where(['model' => Alias::GROUP_MODEL]);
    }

    public function afterDelete(){
        Alias::deleteAll(['entity_id' => $this->owner->id, 'model' => ModelHelper::getModelName($this->owner)]);
    }

    public function afterSave($insert){
        $alias = $this->owner->alias;
        if($alias && $alias->alias != ''){
            return true;
        }
        if(!$alias){
            $alias = \Yii::createObject([
                'class' => Alias::class,
                'entity_id' => $this->owner->id,
                'url' => null,
                'alias' => null,
                'model' => ModelHelper::getModelName($this->owner),
            ]);
        }
     
        $alias = method_exists ( $this->owner , 'urlPattern' ) ? $this->owner->urlPattern($alias) : $this->urlPattern($alias);
        
        if($alias->url == null){
            $alias->url = 'product/default' . '?id=' . $this->owner->id . '&model='. ModelHelper::getModelName($this->owner);
        }
        
        if($alias->groupAlias && $alias->groupUrl == null){
            $alias->groupUrl = 'product/default/group' . '?id=' . $this->owner->group . '&model='. ModelHelper::getModelName($this->owner);
        }
        
        $alias->groupId = $this->owner->group;

        $alias->save();
    }

    public function urlPattern(Alias $alias){
        $alias->url = null;
        $alias->alias = null;
        return $alias;
    }

}

?>