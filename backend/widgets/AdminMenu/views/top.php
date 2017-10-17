<?php
use yii\helpers\Url;
?>
<div class="widget-sub-menu-block">
    <?php

    if ($widget->url->getIsParentActive(['/ads-regions', '/ads-banners'])) {
        echo $widget->a('Banners', '/ads-banners');
        echo $widget->a('Regions', '/ads-regions');
    }

    ?>
</div>