<?php

namespace frontend\modules\rating\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\helpers\ModelHelper;
use frontend\modules\rating\helpers\RatingtHelper;
use frontend\modules\rating\models\Rating;
use yii\base\UnknownPropertyException;
use yii\base\Event;

class RatingBehavior extends Behavior
{    
    const RATING_UPDATE = 'rating-update';
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }
    
    public function __set($name, $value){
        $this->$name = $value;
    }
    
    public function __get($name) 
    {
        
        if(!isset($this->$name)){
            throw new UnknownPropertyException;
        }
        
        if($this->$name === null){
            $this->$name = $this->owner->hasOne(Rating::className(), ['entity_id' => 'id'])->where(['model'=>  ModelHelper::getModelName($this->owner)]);
        }
        
       return $this->$name;
    }

    /**
     * 
     */
    public function afterInit() {
        parent::init();
        $ratingFields =  RatingtHelper::getRatingFields($this->owner);
        foreach($ratingFields as $field => $rule){
            $this->$field = null;
        }
    }
    
    public function afterSave(){
        $ratingFields =  RatingtHelper::getRatingFields($this->owner);
        foreach($ratingFields as $field => $rule){
            if($this->owner->{$field} == 0){
                continue;
            }
            
            $rating = Rating::find()->where([
                'entity_id' => $this->owner->id,
                'model' => ModelHelper::getModelName($this->owner)
            ])->one();
            if(!$rating){
                $rating = Yii::createObject([
                    'class' => Rating::class,
                    'entity_id' => $this->owner->id,
                    'model' => ModelHelper::getModelName($this->owner),
                    'ip' => Yii::$app->request->userIP,
                    'user_id' => Yii::$app->user->id
                ]);
            }
            $rating->rating = $this->owner->{$field};
            $rating->save(); 
        }
        
        Yii::$app->event->trigger(self::RATING_UPDATE, new Event(['sender' => $this->owner]));
    }

}

?>