<?php

namespace common\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Alias;
use common\helpers\ModelHelper;
use common\helpers\URLify;

class UrlBehavior extends Behavior
{
    private $_url;
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    
    public function getAlias(){ 
        return $this->owner->hasOne(Alias::className(), ['entity_id' => 'id'])->where(['model' => ModelHelper::getModelName($this->owner)]);
    }
    
    public function getUrl(){
        if($this->_url){
            return $this->_url;
        }
        if($this->owner->alias){
            return $this->owner->alias->alias;
        }
        $alias = $this->createAlias();
        $this->_url = $alias->alias;
        return  $this->_url;
    }
    public function getGroupAlias(){
        return $this->owner->hasOne(Alias::className(), ['entity_id' => 'group'])->where(['model' => Alias::GROUP_MODEL]);
    }
    
    public function afterDelete(){
        Alias::deleteAll(['entity_id' => $this->owner->id, 'model' => ModelHelper::getModelName($this->owner)]);
    }
    
    /**
     * 
     * @return Alias
     */
    private function createAlias(){
        $alias = \Yii::createObject([
            'class' => Alias::class,
            'entity_id' => $this->owner->id,
            'url' => null,
            'alias' => null,
            'model' => ModelHelper::getModelName($this->owner),
        ]);
        $alias = method_exists ( $this->owner , 'urlPattern' ) ? $this->owner->urlPattern($alias) : $this->urlPattern($alias);
        if($alias->url == null){
            $alias->url = 'product/default' . '?id=' . $this->owner->id . '&model='. ModelHelper::getModelName($this->owner);
        }
        if($alias->groupAlias && $alias->groupUrl == null){
            $alias->groupUrl = 'product/default/group' . '?id=' . $this->owner->group . '&model='. ModelHelper::getModelName($this->owner);
        }
        $alias->groupId = $this->owner->group;
        $alias->save();
        return $alias;
    }
    
    /**
     * 
     * @param \common\models\Alias $alias
     * @return \common\models\Alias
     */
    public function urlPattern(\common\models\Alias $alias){
        $alias->alias = URLify::url($this->owner->titlePattern());        
        $alias->groupAlias = URLify::url($this->owner->title);
        $link = array_column($this->owner->catalog, 'transliteration');
        $alias->prefix = implode('/', $link);
        return $alias;
    }

}

?>