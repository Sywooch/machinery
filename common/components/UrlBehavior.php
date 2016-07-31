<?php

namespace common\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Alias;
use common\helpers\ModelHelper;

class UrlBehavior extends Behavior
{
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }
    
    public function getAlias(){
        return $this->owner->hasOne(Alias::className(), ['entity_id' => 'id'])->where(['model' => ModelHelper::getModelName($this->owner)]);
    }



    public function afterSave($event){
        $alias = $this->owner->alias;
        if($alias && $alias->alias != ''){
            return true;
        }
        if(!$alias){
            $alias = \Yii::createObject([
                'class' => Alias::class,
                'entity_id' => $this->owner->id,
                'url' => '',
                'alias' => '',
                'model' => ModelHelper::getModelName($this->owner),
            ]);
        }

        $alias = method_exists ( $this->owner , 'urlPattern' ) ? $this->owner->urlPattern($this->owner, $alias) : $this->urlPattern($this->owner, $alias);
        $alias->url = $alias->url . '?id=' . $this->owner->id . '&model='. ModelHelper::getModelName($this->owner);
        $alias->save();

        return true;
    }

    public function urlPattern($model, Alias $alias){
        return '';
    }

}

?>