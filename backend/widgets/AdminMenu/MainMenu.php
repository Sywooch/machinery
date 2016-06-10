<?php


namespace backend\widgets\AdminMenu;

use Yii;

class MainMenu extends \yii\bootstrap\Widget
{
    const ACTIVE_CLASS = 'active';

    public function run()
    {
        return $this->render('main', [
            'widget' => $this,
        ]);
    }
    
    private function getUrlParams(){
        $params = explode('/', Yii::$app->requestedRoute);
        return array_shift($params);
    }
    
    public function isActive(array $menuItems = []) {

        if (!Yii::$app->requestedRoute && !$menuItems)
            return self::ACTIVE_CLASS;
        
        if (!$menuItems)
            return;

        $params = $this->getUrlParams();
       
        if (in_array($params, $menuItems))
            return self::ACTIVE_CLASS;
        
        return;
    }
}
