<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;

?>
<div class="widget-sub-menu-block">
    <?php
        //if ($widget->isActive(['product-default'])) {
       //     echo Html::a('<div>Продукты</div>', ['/product-default'], ['class' => $widget->isActive(['product-default'])]);
       // }
        
        if($widget->isActive(['product'])){
            
            echo Html::a('<div>Промокоды</div>', ['/product/promo-codes'], ['class' => $widget->isActive(['promo-codes'])]);
            echo Html::a('<div>Промо продукты</div>', ['/product/promo-products'], ['class' => $widget->isActive(['promo-products'])]);
            echo Html::a('<div>Группы характеристик</div>', ['/product/group-characteristics'], ['class' => $widget->isActive(['group-characteristics'])]);
        }
    ?>
</div>