<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\file\FileInput;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\file\helpers\FileHelper;
use common\modules\file\Asset as FileAsset;
use common\modules\taxonomy\widgets\field\TaxonomyField;

FileAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\ProductDefault */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-phone-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'catalog')->widget(TaxonomyField::classname(), ['vocabularyId' => 1]); ?>

    <?= $form->field($model, 'terms')->widget(TaxonomyField::classname()); ?>
        
    <?= $form->field($model, 'model')->textInput(['maxlength' => 50]) ?>
    
    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'available')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>
    
    <?= $form->field($model, 'old_price')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'photos[]')->widget(FileInput::classname(), FileHelper::FileInputConfig($model, 'photos')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
