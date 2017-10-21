<?php
use frontend\widgets\CategoryMenu\CategoryMenuWidget;
?>
<div class="block-sidebar block-sidebar-bg sidebar">
    <div class="btn-filter-open-wrap">
        <a href="#" type="button" class="open-filter btn-open-filter btn">
            <span>
<!--                <i class="ic-arr-orange-button"></i>-->
                <i class="glyphicon glyphicon-filter"></i>
                <?= Yii::t('app', 'Filter') ?>
            </span>
        </a>
    </div>
    <div class="h2 block-title"><?= Yii::t('app', 'Categories:') ?></div>
    <div class="block-content">
        <?= CategoryMenuWidget::widget() ?>
    </div>
</div>