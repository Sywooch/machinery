<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;
use common\modules\store\models\order\Orders;
use common\modules\store\models\status\StatusRepository;

Asset::register($this);

?>

<div class="widget-menu-block">
    <?php
    echo $widget->a('Главная','/');
    echo $widget->a('Текстовые страницы','/pages');
    echo $widget->a('Каталог','/store/product/index', ['active-url' => ['/store/product/index','/store/promo-products','/store/group-characteristics']]);
    echo $widget->a('Ордеры '.StatusRepository::countStatus([1], Orders::class),'/store/orders');
    echo $widget->a('Слайдер','/ads-slider');
    echo $widget->a('Акции','/ads-actions');
    echo $widget->a('Обзоры','/review');
    echo $widget->a('Адреса магазинов', '/store/shop-address', ['active-url' => ['/store/shop-address']]); 
    echo $widget->a('Отчет импорта','/import/sources');
    echo $widget->a('Таксономия','/taxonomy/vocabulary');
    echo $widget->a('Тарифы (пакеты)','/packages');
    echo $widget->a('Тарифы (опции)','/package-options');
    echo $widget->a('Переводы','/language/source-message/index', ['active-url' => ['/language/source-message','/language/message','/language/default']]);
    echo $widget->a('Пользователи','/user/admin');
    ?>
</div>

