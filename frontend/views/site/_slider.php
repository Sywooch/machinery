<?php

use yii\bootstrap\Html;
use yii2mod\bxslider\BxSlider;
use yii\helpers\ArrayHelper;


foreach(ArrayHelper::getColumn($slider, 'image.0') as $index => $file){
   $images[] = Html::a(Html::img('/'.$file->path.'/'.$file->name),[$slider[$index]->url]);
}

?>


<?= BxSlider::widget([
    'pluginOptions' => [
        'maxSlides' => 1,
        'controls' => true,
        'slideWidth' => 770,
     ],
    'items' => $images
 ]); 
?>
