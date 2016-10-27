<?php
namespace frontend\modules\catalog\widgets\Wish;

use Yii;
use frontend\modules\catalog\models\Wishlist;

class WishWidget extends \yii\bootstrap\Widget
{

    
    
    public function run()
    {
        $count = Wishlist::getCount();
        return $this->render('wish-widget', ['count' => $count]);
    }
}
