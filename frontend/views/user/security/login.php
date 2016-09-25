<?php

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<h2>Вход в личный кабинет</h2>

<div class="user-page login-page">

     
                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => false,
                    'enableClientValidation' => true,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                  
                ]) ?>

                <?= $form->field(
                    $model,
                    'login',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
                )->textInput(['placeholder' => 'Логин / Email']) ?>

                <?= $form
                    ->field(
                        $model,
                        'password',
                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']]
                    )
                    ->passwordInput()
                    ->label(
                        Yii::t('user', 'Password')
                    ) ?>
                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>
                <hr>

                <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                        'captchaAction' => ['/site/captcha'],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Код с картинки',
                        ],
                ]) ?>
    
                
    
                <?= Html::submitButton(
                    'Вход',
                    ['class' => 'btn btn-default btn-block', 'tabindex' => '3']
                ) ?>

                <?php ActiveForm::end(); ?>
    <div class="links">
        <?php if ($module->enablePasswordRecovery): ?>
            <p class="">
                <?= Html::a(Yii::t('user', 'Forgot password?'), ['/user/recovery/request']) ?>
            </p>
        <?php endif ?>

        <?php if ($module->enableRegistration): ?>
            <p class="">
                <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
            </p>
        <?php endif ?>
    </div>
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth'],
        ]) ?>
 
</div>
