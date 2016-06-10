<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductPhoneSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-phone-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'group_id') ?>

    <?= $form->field($model, 'source_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'sku') ?>

    <?php // echo $form->field($model, 'available') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'publish') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'short') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
