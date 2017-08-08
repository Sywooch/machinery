<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdsRegions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-regions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_front')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_subcategory')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->checkbox([]) ?>

    <?= $form->field($model, 'banner_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
