<?php

namespace frontend\components;

use yii\base\Component;
use yii\base\Event;

class EventComponent extends Component {

    public $events;
    
    public function init(){
       foreach($this->events as $event => $data){
            Event::on(self::class, $event, function ($event) use($data){
               $data($event);
            });  
       }
    }

}
