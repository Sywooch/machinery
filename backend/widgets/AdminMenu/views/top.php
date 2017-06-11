<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;

?>
<div class="widget-sub-menu-block">
    <?php

        if($widget->url->getIsParentActive(['/store/product/index','/store/promo-products','/store/group-characteristics'])){
            echo $widget->a('Продукты','/store/product/index');
            echo $widget->a('Промо продукты','/store/promo-products');
            echo $widget->a('Группы характеристик','/store/group-characteristics');
        }
        
        if($widget->url->getIsParentActive('/orders/default')){
            echo $widget->a('Заказы','/orders/default');
            echo $widget->a('Промокоды','/orders/promo-codes');
        }
    ?>
</div>