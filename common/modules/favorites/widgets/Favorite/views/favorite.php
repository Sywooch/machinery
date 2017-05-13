<?php

use common\modules\favorites\Asset;
use yii\bootstrap\Modal;

Asset::register($this);
?>
<div id="favorites-block-widget" class="<?= $count ? 'active' : ''; ?>">
    <?php if (Yii::$app->user->id): ?>
        <a href="/favorites/<?= Yii::$app->user->id ?>">
            <span class="icon"></span>
            <span class="items-count"><?= $count ?></span>
        </a>
    <?php else: ?>
        <div>
            <span class="icon"></span>
            <span class="items-count"><?= $count ?></span>
        </div>
    <?php endif; ?>
</div>

<?php if (!Yii::$app->user->id): ?>
    <?php Modal::begin([
        'id' => 'favorites-auth-modal',
    ]); ?>

    Авторизуйтесь чтобы добавить в избранное

    <?php Modal::end(); ?>
<?php endif; ?>
