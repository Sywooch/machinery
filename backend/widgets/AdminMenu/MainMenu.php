<?php

namespace backend\widgets\AdminMenu;

use Yii;
use yii\helpers\Html;
use backend\widgets\AdminMenu\Url;

class MainMenu extends \yii\bootstrap\Widget
{
    const ACTIVE_CLASS = 'active';
    
    public $url;

    public function run()
    {
        if(!$this->url){
            $this->url = new Url(); 
        }
        
        return $this->render('main', [
            'widget' => $this,
        ]);
    }
    
    public function a($text, $url, $icon){
        $this->url->url = $url;
        return Html::a('<span class="menu-item"><span class="glyphicon '.$icon.' pull-left"></span>'.$text.'</span>', [$this->url->url], ['class' => $this->url->isParentActive ? self::ACTIVE_CLASS:'']);
    }     
}
