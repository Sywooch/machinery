<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('user', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->beginBlock('title_panel');
echo 'Register <span class="white">New account</span>';
$this->endBlock();
?>

<div class="user-page register-page">
    <div class="container">

        <?php $form = ActiveForm::begin([
            'id' => 'registration-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'validateOnBlur' => false,
            'validateOnType' => false,
            'validateOnChange' => false,
        ]); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username'); ?>
                <?= $form->field($model, 'email') ?>
            </div>
            <div class="col-md-6">
                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                    'captchaAction' => ['/site/captcha'],
                    'options' => [
                        'class' => 'form-control',
                    ],
                ])->label(
                    Yii::t('user', 'What is the sum of:')
                ); ?>
            </div>
            <div class="col-md-6">
                <div class="links">
                    <?php if ($module->enablePasswordRecovery): ?>
                        <p class="">
                            <?= Html::a(Yii::t('user', 'Forgot your password?'), ['/user/recovery/request']) ?>
                        </p>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?= Html::submitButton(Yii::t('user', 'Register'), ['class' => 'btn btn-warning btn-submit']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>


    </div>
</div>
