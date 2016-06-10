<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\assets\Asset;

Asset::register($this);

?>
<div class="widget-sub-menu-block">
    <?php
        if ($widget->isActive(['product-phone'])) {
            echo Html::a('<div>Телефоны</div>', ['/product-phone'], ['class' => $widget->isActive(['product-phone'])]);
        }
    ?>
</div>