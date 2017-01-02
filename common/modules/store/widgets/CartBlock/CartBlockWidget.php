<?php


namespace common\modules\store\widgets\CartBlock;

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
