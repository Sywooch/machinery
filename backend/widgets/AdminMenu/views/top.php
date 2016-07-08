<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\assets\Asset;

Asset::register($this);

?>
<div class="widget-sub-menu-block">
    <?php
        if ($widget->isActive(['product-default'])) {
            echo Html::a('<div>Продукты</div>', ['/product-default'], ['class' => $widget->isActive(['product-default'])]);
        }
    ?>
</div>