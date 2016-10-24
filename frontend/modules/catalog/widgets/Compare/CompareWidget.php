<?php
namespace frontend\modules\catalog\widgets\Compare;

use Yii;
use frontend\modules\catalog\models\Compares;

class CompareWidget extends \yii\bootstrap\Widget
{

    
    
    public function run()
    {
        $count = Compares::getCount();
        return $this->render('compare-widget',['count' => $count]);
    }
}
