<?php

use yii\helpers\Html;
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('../profile/_photo', ['profile' => $model]) ?>
        <?= $this->render('../profile/_menu') ?>
    </div>
    <div class="col-md-9">
        <?= $this->render('../profile/_head') ?>
        <?php $form = ActiveForm::begin([
            'id' => 'profile-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validateOnBlur' => false,
        ]); ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'last_name') ?>

        <?= $form->field($model, 'website') ?>

        <?= $form->field($model, 'phone') ?>

        <?= $form->field($model, 'location')->dropDownList([]) ?>

        <?= $form->field($model, 'bio')->textarea(['placeholder' => Yii::t('user', 'Im someting write here....This is active input')]) ?>


        <h2><?= Yii::t('user', 'Social media'); ?>:</h2>

        <?= $form->field($model, 'social[facebook]')->label('Facebook:') ?>
        <?= $form->field($model, 'social[twitter]')->label('Twitter:') ?>
        <?= $form->field($model, 'social[linkedin]')->label('Linkedin:') ?>
        <?= $form->field($model, 'social[skype]')->label('Skype:') ?>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-9">
                <?= Html::submitButton(Yii::t('user', 'Save changes'), ['class' => 'btn btn-block btn-success']) ?>
                <br>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
