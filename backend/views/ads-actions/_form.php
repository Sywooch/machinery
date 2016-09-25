<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use common\modules\file\helpers\FileHelper;
use common\modules\file\Asset as FileAsset;
use kartik\file\FileInput;

FileAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\AdsActions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-actions-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'image[]')->widget(FileInput::classname(),FileHelper::FileInputConfig($model, 'image')); ?>
    
    
    <?= $form->field($model, 'from')->widget(DateTimePicker::classname(), [
	'options' => ['placeholder' => 'Enter event time ...'],
	'pluginOptions' => [
		'autoclose' => true
	]
    ]); ?>
    
    <?= $form->field($model, 'to')->widget(DateTimePicker::classname(), [
	'options' => ['placeholder' => 'Enter event time ...'],
	'pluginOptions' => [
		'autoclose' => true
	]
    ]); ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
