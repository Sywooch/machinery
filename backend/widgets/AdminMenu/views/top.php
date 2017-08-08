<?php
use yii\helpers\Url;
?>
<div class="widget-sub-menu-block">
    <?php

    if ($widget->url->getIsParentActive(['/ads-regions', '/ads-banners'])) {
        echo $widget->a('Banners', Url::to(['/ads-banners']));
        echo $widget->a('Regions', Url::to(['/ads-regions']));
    }

    ?>
</div>