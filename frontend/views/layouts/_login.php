<?php
use yii\helpers\Html;
use yii\bootstrap\BootstrapPluginAsset;

BootstrapPluginAsset::register($this);
?>
<div class="login">
    <?php if(Yii::$app->user->id):?>
    

    <a href="#" id="popover-login" data-toggle="popover" data-placement="bottom" class="popover-toggle"><?=Yii::$app->user->identity->email;?> <b class="caret"></b></a>

    <div id="popover-login-content" class="hidden">
        <div class="actions">
            <a href="/user/<?=Yii::$app->user->id;?>"class="btn btn-orange btn-custom">Профиль</a>
            <a href="/user/logout" data-method="post" class="btn btn-default btn-custom">Выход</a>
        </div>
    </div>
    <div id="popover-overlay" ></div>
    <?php else:?>
     <a href="/login">Войти</a><span></span><a href="/user/register" ><i class="fa fa-user-o" aria-hidden="true"></i> Регистрация</a>
    <?php endif;?>
</div>
