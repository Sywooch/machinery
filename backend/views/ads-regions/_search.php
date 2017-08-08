<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdsRegionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-regions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'price_front') ?>

    <?= $form->field($model, 'price_category') ?>

    <?= $form->field($model, 'price_subcategory') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'banner_count') ?>

    <?php // echo $form->field($model, 'transliteration') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
