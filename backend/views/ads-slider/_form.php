<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\file\helpers\FileHelper;
use common\modules\file\Asset as FileAsset;
use kartik\file\FileInput;

FileAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\AdsSlider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-slider-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'image[]')->widget(FileInput::classname(),FileHelper::FileInputConfig($model, 'image')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
