<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;

?>
<div class="widget-sub-menu-block">
    <?php
        /*if ($widget->isActive(['product-default','product-pc','product-av'])) {
            echo Html::a('<div>Мобильный</div>', ['/product-default'], ['class' => $widget->isActive(['product-default'])]);
            echo Html::a('<div>Компьютеры</div>', ['/product-pc'], ['class' => $widget->isActive(['product-pc'])]);
            echo Html::a('<div>Аудио Видео</div>', ['/product-av'], ['class' => $widget->isActive(['product-av'])]);
        }*/
        
        if($widget->url->getIsParentActive(['/store/product/list','/store/promo-products','/store/group-characteristics'])){
            echo $widget->a('Продукты','/store/product/list?model=ProductDefault');
            echo $widget->a('Промо продукты','/store/promo-products');
            echo $widget->a('Группы характеристик','/store/group-characteristics');
        }
        
        if($widget->url->getIsParentActive('/orders/default')){
            echo $widget->a('Заказы','/orders/default');
            echo $widget->a('Промокоды','/orders/promo-codes');
        }
    ?>
</div>