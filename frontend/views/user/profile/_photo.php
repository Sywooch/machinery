<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\file\widgets\FileInputAvatar\FileInputAvatarWidget;

/**
 * @var dektrium\user\models\User $user
 */

$user = Yii::$app->user->identity;
?>
<a href="#" type="button" class="open-filter btn-open-filter btn"><i class="ic-arr-orange-button"></i></a>
<div class="block-user-avatar">
    <div class="header-avatar"">
        <h3 class="panel-title">
            <?= empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name); ?>
        </h3>
    </div>
    <div class="_block">
        <?php if ($profile->user_id == Yii::$app->user->id): ?>
            <?php
            $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]);
            ?>
            <?= $form->field($profile->user, 'photo', ['template' => '{input}{error}'])->widget(FileInputAvatarWidget::class, ['uploadUrl' => '/profile/photo-upload']); ?>
            <?php ActiveForm::end(); ?>

        <?php endif; ?>
    </div>
</div>
