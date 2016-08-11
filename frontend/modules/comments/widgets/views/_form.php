<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
use yii\captcha\Captcha;
use common\modules\file\helpers\StyleHelper;
use kartik\rating\StarRating;
?>

<div class="title">Новый отзыв</div>
<?php
$form = ActiveForm::begin(['id' => 'comment-form'])
?>

<div class="comment-user-info">
    <?php if($avatar): ?>
        <?=Html::img('/'.StyleHelper::getPreviewUrl($avatar, '100x100'), ['width' => '60px', 'class' => 'img-circle']); ?>
    <?php else:?>
        <?=Html::img('/files/no-avatar.jpg', ['width' => '60px', 'class' => 'img-circle']);?>
    <?php endif;?>
    <?php if (!Yii::$app->user->id): ?>
        <?php echo $form->field($model, 'name')->textInput(); ?>
        <?php echo $form->field($model, 'feed_back')->textInput()->hint('Контактные данные'); ?>
    <?php else: ?>
        <?=Yii::$app->user->identity->profile->name ? Html::a(Html::encode(Yii::$app->user->identity->profile->name), '/user/' . Yii::$app->user->id) : Html::a(Html::encode(Yii::$app->user->identityusername), '/user/' . Yii::$app->user->id); ?>
    <?php endif; ?>
</div>

<?php if (!$model->parent_id):?>
<?php echo $form->field($model, 'positive')->textarea(['rows' => 4]); ?>
<?php echo $form->field($model, 'negative')->textarea(['rows' => 4]); ?>
<?php endif;?>

<?php echo $form->field($model, 'comment')->textarea(['rows' => 8]); ?>

<?php echo $form->field($model, 'rating')->widget(StarRating::classname(), [
    'pluginOptions' => ['size'=>'sm']
]); ?>

<?php if (!Yii::$app->user->id): ?>
<?php
echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-6">{input}</div></div>',
            'captchaAction' => '/site/captcha'
	]);
?>
<?php endif;?>
	
<?= Html::submitButton('Отправить', ['class' => 'btn btn-default btn-block']) ?>

<?php ActiveForm::end(); ?>
