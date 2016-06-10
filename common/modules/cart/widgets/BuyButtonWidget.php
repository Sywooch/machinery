<?php


namespace common\modules\cart\widgets;

use Yii;

class BuyButtonWidget extends \yii\bootstrap\Widget
{
    
    public $product;

    public function run()
    {
        return $this->render('buy-button-widget', [
                'product' => $this->product,
        ]);
    }
}
