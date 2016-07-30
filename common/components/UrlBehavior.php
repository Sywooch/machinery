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
        return $this->owner->hasOne(Alias::className(), ['id' => 'user_id'])->where(['model' => ModelHelper::getModelName($this->owner)]);
    }



    public function afterSave($event){

        $alias = $this->owner->alias;
        if($alias && $alias->alias != ''){
            return true;
        }
        if(method_exists ( $this->owner , 'urlPattern' )){
            $alias->alias = $this->owner->urlPattern($this->owner);
        }else{
            $alias->alias = $this->urlPattern($this->owner);
        }
        if($alias->alias){
            $alias->save();
        }
        return true;
    }

    public function urlPattern(){
        return '';
    }

}

?>