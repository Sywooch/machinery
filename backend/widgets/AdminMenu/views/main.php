<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;
use common\modules\store\models\order\Orders;
use common\modules\store\models\status\StatusRepository;
use yii\helpers\Url;

Asset::register($this);

?>

<div class="widget-menu-block">
    <?php
    echo $widget->a('Главная','/');
    echo $widget->a('Список объявлений','/advert');
    echo $widget->a('Текстовые страницы','/pages');
    echo $widget->a('Banners', '/ads-banners', ['active-url' => ['/ads-banners','/ads-regions']]);
    echo $widget->a('Таксономия', '/taxonomy/vocabulary');
    echo $widget->a('Тарифы (пакеты)', '/packages');
    echo $widget->a('Тарифы (опции)', '/package-options');
    echo $widget->a('Переводы', '/language/source-message/index', ['active-url' => ['/language/source-message','/language/message','/language/default']]);
    echo $widget->a('Пользователи', '/user/admin');
    echo $widget->a('Валюты', '/currency');
    ?>
</div>

