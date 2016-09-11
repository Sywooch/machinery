<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\assets\Asset;

Asset::register($this);

?>

<div class="widget-menu-block">
    <?php
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-leaf pull-left"></span>Главная</span>', ['/'], ['class' => $widget->isActive()]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-edit  pull-left"></span>Текстовые страницы</span>', ['/pages'], ['class' => $widget->isActive(['pages'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-info-sign  pull-left"></span>Информация брендов</span>', ['/brand-info'], ['class' => $widget->isActive(['brand-info'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-asterisk  pull-left"></span>Каталог</span>', ['/product-default'], ['class' => $widget->isActive(['product-default'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-cog  pull-left"></span>Настройка продукта</span>', ['/product/promo-codes'], ['class' => $widget->isActive(['product'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-info-sign pull-left"></span>Отчет импорта</span>', ['/import/sources'], ['class' => $widget->isActive(['import'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-list-alt pull-left"></span>Таксономия</span>', ['/taxonomy/vocabulary'], ['class' => $widget->isActive(['taxonomy'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-user pull-left"></span>Пользователи</span>', ['/user/admin'], ['class' => $widget->isActive(['user'])]);
    
    ?>
</div>

