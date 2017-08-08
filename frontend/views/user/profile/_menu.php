<?php

use yii\helpers\Html;
use yii\widgets\Menu;

/**
 * @var dektrium\user\models\User $user
 */

$user = Yii::$app->user->identity;
?>
<div class="block-account-options">
    <div class="_block">
        <header>
            <?= Yii::t('user', 'Account options'); ?>
        </header>

        <?= Menu::widget([
            'items' => [
                ['label' => '<i class="fa fa-cog" aria-hidden="true"></i> ' . Yii::t('user', 'View profile'), 'url' => ['/user/profile']],
                ['label' => '<i class="fa fa-user" aria-hidden="true"></i> ' . Yii::t('user', 'My Account'), 'url' => ['/user/settings/account']],
                ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
                ['label' => '<i class="fa fa-list" aria-hidden="true"></i> ' . Yii::t('app', 'My Listings'), 'url' => ['/advert/listing']],
                ['label' => '<i class="fa fa-heart" aria-hidden="true"></i> ' . Yii::t('app', 'My favorite'), 'url' => ['/profile/favorite']],
                ['label' => '<i class="fa fa-heart" aria-hidden="true"></i> ' . Yii::t('app', 'Premium advertising'), 'url' => ['/ads/index']],
            ],
            'encodeLabels' => false,
        ]); ?>
    </div>

</div>
<div class="_bottom text-center">
    <p><?= Yii::t('user', 'Joined {days} days {hours} hours {minutes} minutes ago.', [
            'days' => date('d', time()-$user->created_at),
            'hours' =>  date('h', time()-$user->created_at),
            'minutes' =>  date('i', time()-$user->created_at),
        ]) ?></p>
    <p>
        <?= Html::a(Yii::t('user', 'Exit'), ['/user/logout'], ['data-method' => 'post', 'class' => 'btn btn-warning btn-exit']); ?>
    </p>
</div>

