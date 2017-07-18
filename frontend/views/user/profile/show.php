<?php

use yii\helpers\Html;

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3   sidebar sidebar-account">
            <?= $this->render('_photo', ['profile' => $profile]) ?>
            <?= $this->render('_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">
                <?= $this->render('_head') ?>

                <div class="cf">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading _header">Recently viewed</div>
                            <div class="_list panel-body">
                                <ul>
                                    <li><a href="#">Далеко-далеко за.</a></li>
                                    <li><a href="#">Алфавит, великий.</a></li>
                                    <li><a href="#">Снова, осталось.</a></li>
                                    <li><a href="#">Образ, назад!</a></li>
                                    <li><a href="#">Свое, свою.</a></li>
                                    <li><a href="#">Все, имени!</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading _header">My favorite listing</div>
                            <div class="_list panel-body">
                                <ul>
                                    <li><a href="#">Далеко-далеко за.</a></li>
                                    <li><a href="#">Запятых, предложения.</a></li>
                                    <li><a href="#">Пунктуация, вопрос.</a></li>
                                    <li><a href="#">Продолжил, речью.</a></li>
                                    <li><a href="#">Мир, страну!</a></li>
                                    <li><a href="#">Всемогущая, единственное!</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>