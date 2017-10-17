<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="widget-user-block">
    <?php if ($type): ?>

    <?php else: ?>
        <div>
            <?php
//            if (isset($model->avatar->filename))
//                echo Html::a(Html::img('/files/profile/100x100/' . $model->avatar->filename, ['width' => '48px', 'class' => 'img-circle']), ['/user/settings/profile']);
//            else
//                echo Html::a(Html::img('/files/no-avatar.png', ['width' => '48px', 'class' => 'img-circle']), ['/user/settings/profile']);
//
            echo Html::a($model->email, ['/user/settings/profile']);
            ?>
        </div>
    <?php endif; ?>
</div>

