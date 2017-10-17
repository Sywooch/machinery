<?php

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->beginBlock('title_panel');
echo 'Login <span class="white">User</span>';
$this->endBlock();

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

//echo $this->layout;

?>

<div class="container">
    <?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>
</div>
<div class="container">

    <div class="user-page login-page row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,

            ]) ?>

            <?= $form->field(
                $model,
                'login',
                ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
            ); ?>

            <?= $form
                ->field(
                    $model,
                    'password',
                    ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']]
                )
                ->passwordInput() ?>

            <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                'captchaAction' => ['/site/captcha'],
                'options' => [
                    'class' => 'form-control',
                ],
            ])->label(
                Yii::t('user', 'What is the sum of:')
            ); ?>

            <?= Html::submitButton(
                Yii::t('user', 'Login'),
                ['class' => 'btn btn-warning btn-submit', 'tabindex' => '3']
            ) ?>

            <?php ActiveForm::end(); ?>
            <div class="links text-center">
                <?php if ($module->enablePasswordRecovery): ?>
                    <p class="">
                        <?= Html::a(Yii::t('user', 'Forgot your password?'), ['/user/recovery/request']) ?>
                    </p>
                <?php endif ?>

                <?php if ($module->enableRegistration): ?>
                    <p class="">
                        <?= Html::a(Yii::t('user', 'Register new user'), ['/user/registration/register']) ?>
                    </p>
                <?php endif ?>
            </div>
            <?= Connect::widget([
                'baseAuthUrl' => ['/user/security/auth'],
            ]) ?>
        </div>

    </div>

</div>