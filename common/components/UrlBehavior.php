<?php

namespace common\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\helpers\ModelHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyIndex;
use common\modules\taxonomy\helpers\TaxonomyHelper;

class UrlBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }
    



    public function beforeSave($event){

        if(!isset($this->owner->url)){
            return false;
        }

        if($this->owner->url){
            return true;
        }

        if(method_exists ( $this->owner , 'urlPattern' )){
            $this->owner->url = $this->owner->urlPattern($this->owner);
        }else{
            $this->owner->url = $this->urlPattern($this->owner);
        }
        exit('AAA');
    }

    public function urlPattern(){
        return null;
    }

}

?>