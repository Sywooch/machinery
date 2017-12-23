<?php

use common\modules\favorites\Asset;
use yii\bootstrap\Modal;

Asset::register($this);
?>

    <?php if (Yii::$app->user->id):
        if(!$count): ?>
        <a href="<?= \yii\helpers\Url::to(['favorites/default/add']) ?>" class="<?= $classBtn ?> add-favorite btn-favorite"
           data-id="<?= $model->id ?>"
           data-model="<?= \yii\helpers\StringHelper::basename(get_class($model)) ?>"
           data-text="<?= Yii::t('app', 'Remove from favorites') ?>"
           data-action="add"
           data-href="<?= \yii\helpers\Url::to(['favorites/default/remove']) ?>"
        >
            <i class="<?= $classIcon ?>" aria-hidden="true"></i>
            <span><?= Yii::t('app', 'Add favorites') ?></span>
        </a>
            <?php else: ?>
            <a href="<?= \yii\helpers\Url::to(['favorites/default/remove']) ?>" class="<?= $classBtn ?> remove-favorite btn-favorite"
               data-id="<?= $model->id ?>"
               data-model="<?= \yii\helpers\StringHelper::basename(get_class($model)) ?>"
               data-text="<?= Yii::t('app', 'Add favorites') ?>"
               data-action="remove"
               data-href="<?= \yii\helpers\Url::to(['favorites/default/add']) ?>"
            >
                <i class="<?= $classIcon ?>" aria-hidden="true"></i>
                <span><?= Yii::t('app', 'Remove from favorites') ?></span>
            </a>
            <?php endif; ?>
    <?php else: ?>
<!--        <div>-->
<!--            <span class="icon"></span>-->
<!--            <span class="items-count">--><?//= $count ?><!--</span>-->
<!--        </div>-->
    <?php endif; ?>


<?php if (!Yii::$app->user->id): ?>
    <?php Modal::begin([
        'id' => 'favorites-auth-modal',
    ]); ?>

    Авторизуйтесь чтобы добавить в избранное

    <?php Modal::end(); ?>
<?php endif; ?>
