<?php

namespace common\modules\store\classes\uus;

use yii\base\Object;
use common\modules\store\classes\uus\UUSInterface;

class UUS extends Object implements UUSInterface{
    
    private $_id = '0';
    
    public function getId(){
        return $this->_id;
    }
}