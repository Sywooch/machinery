<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Premium advertising');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-account">
            <?= $this->render('/user/profile/_photo', ['profile' => $profile]) ?>
            <?= $this->render('/user/profile/_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">

                <div class="account-menu-tab">
                    Premium advertising <a href="#" class="btn btn-yellow">Heed help? Click here</a>
                </div>

                <?php foreach ($regions as $region):?>
                    <?php $available = $region->banner_count > $regionsRepository->countBanners($region); ?>
                    <div class="region">
                        <div class="title"><?=$region->name?></div>
                        <div class="size">Size <?=$region->size?></div>
                        <div class="price">??$ for 30 days</div>
                        <div class="btn btn-available <?=$available ? 'available' : 'not-available'?>"><?=$available ? 'available' : 'not available'?></div>
                        <a href="#" class="btn btn-yellow <?=$available ? 'available' : 'not-available'?>" <?=$available ? '' : 'disabled'?>>Buy now</a>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </div>
</div>