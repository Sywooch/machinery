<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;


$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<h2>Регистрация нового пользователя</h2>
<div class="user-page register-page">
   
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'name') ?>
    
                <?= $form->field($model, 'email') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>
    
                <hr>
                <?= $form->field($model, 'birth')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '99.99.9999',
                ])->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true
                    ]
                ]); ?>
                
                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '+38 (099)-999-99-99',
                ])->hint('Формат: +38 (0XX) XXX-XX-XX'); ?> 
                
                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-default btn-block']) ?>

                <?php ActiveForm::end(); ?>
    <div class="links">
        <p class="text-center auth-link">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>

</div>
