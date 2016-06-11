<?php


namespace frontend\modules\cart\widgets;

use Yii;

class CartBlockWidget extends \yii\bootstrap\Widget
{
    
    public function run()
    {
        return $this->render('cart-block-widget', [
                'order' => Yii::$app->cart->getOrder(),
        ]);
    }
}
