<?php


namespace backend\widgets\AdminMenu;

use Yii;

class TopMenu extends \yii\bootstrap\Widget
{
    const ACTIVE_CLASS = 'active';

    public function run()
    {
        return $this->render('top', [
            'widget' => $this,
        ]);
    }
    
    private function getUrlParams(){
        $params = explode('/', Yii::$app->requestedRoute);
        return $params;
    }
    
    public function isActive(array $menuItems = []) {

        if (!Yii::$app->requestedRoute && !$menuItems){
            return self::ACTIVE_CLASS;
        }
        
        if (!$menuItems){
            return;
        }
        $params = $this->getUrlParams();
        //print_r($params); print_r($menuItems); print_r(array_intersect($params, $menuItems));  exit('S');
        if (!empty(array_intersect($params, $menuItems))){
            return self::ACTIVE_CLASS;
        }
        return;
    }
}
