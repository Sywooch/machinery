<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'My offers');
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
                <?= $this->render('/user/profile/_head') ?>

                <div class="list-offers _list cf">
                    Здесь надо вывести виджет Gridview
                </div> <!-- .list-favorite-adv -->

            </div>
        </div>
    </div>
</div>