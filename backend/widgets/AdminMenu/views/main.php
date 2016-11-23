<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;
use common\modules\orders\models\Orders;
use common\modules\orders\models\StatusRepository;

Asset::register($this);

?>

<div class="widget-menu-block">
    <?php
    echo $widget->a('Главная','/','glyphicon-leaf');
    echo $widget->a('Информация брендов','/brand-info','glyphicon-info-sign');
    echo $widget->a('Текстовые страницы','/pages','glyphicon-edit');
    echo $widget->a('Каталог','/store/product/list','glyphicon-asterisk');
    echo $widget->a('Ордеры '.StatusRepository::countStatus([1], Orders::class),'/orders/default', 'glyphicon-shopping-cart');
    echo $widget->a('Слайдер','/ads-slider','glyphicon-list-alt');
    echo $widget->a('Акции','/ads-actions','glyphicon-list-alt');
    echo $widget->a('Обзоры','/review','glyphicon-list-alt');
    echo $widget->a('Адреса магазинов','/shop-address','glyphicon-map-marker');
    echo $widget->a('Отчет импорта','/import/sources','glyphicon-info-sign');
    echo $widget->a('Таксономия','/taxonomy/vocabulary','glyphicon-list-alt');
    echo $widget->a('Пользователи','/user/admin','glyphicon-user');
    ?>
</div>

