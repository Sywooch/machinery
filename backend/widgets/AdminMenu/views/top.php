<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;

?>
<div class="widget-sub-menu-block">
    <?php
        if ($widget->isActive(['product-default','product-pc','product-av'])) {
            echo Html::a('<div>Мобильный</div>', ['/product-default'], ['class' => $widget->isActive(['product-default'])]);
            echo Html::a('<div>Компьютеры</div>', ['/product-pc'], ['class' => $widget->isActive(['product-pc'])]);
            echo Html::a('<div>Аудио Видео</div>', ['/product-av'], ['class' => $widget->isActive(['product-av'])]);
        }
        
        if($widget->isActive(['product'])){
            
            echo Html::a('<div>Промокоды</div>', ['/product/promo-codes'], ['class' => $widget->isActive(['promo-codes'])]);
            echo Html::a('<div>Промо продукты</div>', ['/product/promo-products'], ['class' => $widget->isActive(['promo-products'])]);
            echo Html::a('<div>Группы характеристик</div>', ['/product/group-characteristics'], ['class' => $widget->isActive(['group-characteristics'])]);
        }
        if($widget->isActive(['ads-slider','ads-actions'])){
            
            echo Html::a('<div>Слайдер</div>', ['/ads-slider'], ['class' => $widget->isActive(['ads-slider'])]);
            echo Html::a('<div>Акции</div>', ['/ads-actions'], ['class' => $widget->isActive(['ads-actions'])]);
          }
    ?>
</div>