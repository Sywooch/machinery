<?php

use yii\helpers\Html;
use dektrium\user\widgets\UserMenu;
use yii\widgets\Menu;

/**
 * @var dektrium\user\models\User $user
 */

$user = Yii::$app->user->identity;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= Yii::t('user', 'Account options'); ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget([
            'items' => [
                ['label' => Yii::t('user', 'View profile'), 'url' => ['/user/profile']],
                ['label' => Yii::t('user', 'My Account'), 'url' => ['/user/settings/account']],
                ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
            ],
        ]); ?>

    </div>
</div>
<div>
    <?= Yii::t('user', 'Joined {days} days {hours} hours {minutes} minutes ago.', [
        'days' => date('d', time()-$user->created_at),
        'hours' =>  date('h', time()-$user->created_at),
        'minutes' =>  date('i', time()-$user->created_at),
    ]) ?>
</div>


<?= Html::a(Yii::t('user', 'Exit'), ['/user/logout'], ['data-method' => 'post', 'class' => 'btn btn-exit']); ?>
