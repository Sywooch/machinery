<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;
use common\modules\orders\models\Orders;
use common\modules\orders\models\StatusRepository;

Asset::register($this);

?>

<div class="widget-menu-block">
    <?php
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-leaf pull-left"></span>Главная</span>', ['/'], ['class' => $widget->isActive()]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-edit  pull-left"></span>Текстовые страницы</span>', ['/pages'], ['class' => $widget->isActive(['pages'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-info-sign  pull-left"></span>Информация брендов</span>', ['/brand-info'], ['class' => $widget->isActive(['brand-info'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-asterisk  pull-left"></span>Каталог</span>', ['/product-default'], ['class' => $widget->isActive(['product-default','product-pc','product-av'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-shopping-cart pull-left"></span>Заказы<span class="badge">' . StatusRepository::countStatus([1], Orders::class) . '</span></span>', ['/orders'], ['class' => $widget->isActive(['orders'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-cog  pull-left"></span>Настройка продукта</span>', ['/orders/promo-codes'], ['class' => $widget->isActive(['product'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-list-alt pull-left"></span>ADS</span>', ['/ads-slider'], ['class' => $widget->isActive(['ads-slider','ads-actions'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-list-alt pull-left"></span>обзоры</span>', ['/review'], ['class' => $widget->isActive(['review'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-map-marker  pull-left"></span>Адреса магазинов</span>', ['/shop-address'], ['class' => $widget->isActive(['shop-address'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-info-sign pull-left"></span>Отчет импорта</span>', ['/import/sources'], ['class' => $widget->isActive(['import'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-list-alt pull-left"></span>Таксономия</span>', ['/taxonomy/vocabulary'], ['class' => $widget->isActive(['taxonomy'])]);
    echo Html::a('<span class="menu-item"><span class="glyphicon glyphicon-user pull-left"></span>Пользователи</span>', ['/user/admin'], ['class' => $widget->isActive(['user'])]);
    
    ?>
</div>

