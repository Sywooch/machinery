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
    echo $widget->a('Текстовые страницы','/pages');
    echo $widget->a('Banners', Url::to(['/ads-banners']), ['active-url' => ['/ads-banners','/ads-regions']]);
    echo $widget->a('Таксономия', Url::to(['/taxonomy/vocabulary']));
    echo $widget->a('Тарифы (пакеты)',Url::to(['/packages']));
    echo $widget->a('Тарифы (опции)',Url::to(['/package-options']));
    echo $widget->a('Переводы',Url::to(['/language/source-message/index']), ['active-url' => ['/language/source-message','/language/message','/language/default']]);
    echo $widget->a('Пользователи',Url::to(['/user/admin']));
    ?>
</div>

