<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('user', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-page register-page">

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'validateOnBlur' => false,
        'validateOnType' => false,
        'validateOnChange' => false,
    ]); ?>

    <?= $form->field($model, 'username'); ?>

    <?= $form->field($model, 'email') ?>

    <?php if ($module->enableGeneratingPassword == false): ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    <?php endif ?>

    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
        'captchaAction' => ['/site/captcha'],
        'options' => [
            'class' => 'form-control',
        ],
    ])->label(
        Yii::t('user', 'What is the sum of:')
    ); ?>

    <div class="links">
        <?php if ($module->enablePasswordRecovery): ?>
            <p class="">
                <?= Html::a(Yii::t('user', 'Forgot your password?'), ['/user/recovery/request']) ?>
            </p>
        <?php endif ?>
    </div>
    <?= Html::submitButton(Yii::t('user', 'Register'), ['class' => 'btn btn-default btn-block']) ?>

    <?php ActiveForm::end(); ?>


</div>
