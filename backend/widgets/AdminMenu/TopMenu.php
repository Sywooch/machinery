<?php

namespace backend\widgets\AdminMenu;

use Yii;
use yii\helpers\Html;

class TopMenu extends \yii\bootstrap\Widget
{
    const ACTIVE_CLASS = 'active';

    public $url;

    public function run()
    {
        if(!$this->url){
            $this->url = new Url(); 
        }
        return $this->render('top', [
            'widget' => $this,
        ]);
    }
    
    public function a($text, $url){
        $this->url->url = $url;
        return Html::a('<div>'.$text.'</div>', [$this->url->url], ['class' => $this->url->isActive ? self::ACTIVE_CLASS:'']);
    }
     
}
