<?php

use yii\helpers\Html;
use backend\widgets\AdminMenu\Asset;
use common\modules\store\models\order\Orders;
use common\modules\store\models\status\StatusRepository;
use yii\helpers\Url;

Asset::register($this);

?>

<div class="widget-menu-block">
    <ul class="sidebar-menu" data-widget="tree">

        <li <?= Yii::$app->controller->id == 'site' ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/site/index']) ?>">
                <i class="fa fa-home"></i> <span>Главная</span>
            </a>
        </li>

        <li <?= Yii::$app->controller->id == 'pages' ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/pages/index']) ?>">
                <i class="fa fa-file-o"></i> <span>Текстовые страницы</span>
            </a>
        </li>
        <li <?= Yii::$app->controller->id == 'advert' ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/advert/index']) ?>">
                <i class="fa fa-file-text-o"></i> <span>Список объявлений</span>
            </a>
        </li>
        <li <?= Yii::$app->controller->id == 'taxonomy' || (Yii::$app->controller->id == 'items' && Yii::$app->controller->action->id == 'hierarchy') ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/taxonomy/vocabulary']) ?>">
                <i class="fa fa-th-list"></i> <span>Таксономия</span>
            </a>
        </li>
        <li <?= Yii::$app->controller->id == 'packages' ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/packages/index']) ?>">
                <i class="fa fa-clock-o"></i> <span>Тарифы (пакеты)</span>
            </a>
        </li>
        <li <?= Yii::$app->controller->id == 'package-options' ? 'class="active"' : '' ?> data-ctrl="<?= Yii::$app->controller->id ?>">
            <a href="<?= Url::to(['/package-options/index']) ?>">
                <i class="fa fa-th"></i> <span>Тарифы (опции)</span>
            </a>
        </li>

        <li <?= (Yii::$app->controller->id == 'ads-banners' || Yii::$app->controller->id == 'ads-regions') ? 'class="active"' : '' ?> data-ctrl="<?= Yii::$app->controller->id ?>">
            <a href="<?= Url::to(['/ads-banners']) ?>">
                <i class="fa fa-area-chart"></i> <span>Banners</span>
            </a>
        </li>
        <li <?= Yii::$app->controller->id == 'source-message' ? 'class="active"' : '' ?> data-ctrl="<?= Yii::$app->controller->id ?>">
            <a href="<?= Url::to(['/language/source-message/index']) ?>">
                <i class="fa fa-sign-language"></i> <span>Переводы</span>
            </a>
        </li>
        <li <?= Yii::$app->controller->id == 'admin' ? 'class="active"' : '' ?> data-ctrl="<?= Yii::$app->controller->id ?>">
            <a href="<?= Url::to(['/user/admin']) ?>">
                <i class="fa fa-users"></i> <span>Пользователи</span>
            </a>
        </li>
        <li <?= Yii::$app->controller->id == 'currency' ? 'class="active"' : '' ?> data-ctrl="<?= Yii::$app->controller->id ?>">
            <a href="<?= Url::to(['/currency/index']) ?>">
                <i class="fa fa-money"></i> <span>Валюты</span>
            </a>
        </li>
        <?php
//        echo $widget->a('Список объявлений', '/advert');
//        echo $widget->a('Banners', '/ads-banners', ['active-url' => ['/ads-banners', '/ads-regions']]);
//        echo $widget->a('Таксономия', '/taxonomy/vocabulary');
//        echo $widget->a('Тарифы (пакеты)', '/packages');
//        echo $widget->a('Тарифы (опции)', '/package-options');
//        echo $widget->a('Переводы', '/language/source-message/index', ['active-url' => ['/language/source-message', '/language/message', '/language/default']]);
//        echo $widget->a('Пользователи', '/user/admin');
//        echo $widget->a('Валюты', '/currency');
        ?>
    </ul>
</div>

