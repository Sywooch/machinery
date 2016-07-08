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
    
    <?= $form->field($model, 'photos[]')->widget(FileInput::classname(),FileHelper::FileInputConfig($model, 'photos')); ?>

    <?= $form->field($model, 'catalog')->widget(Select2::classname(), [
            'options' => [
                'placeholder' => 'Select terms ...', 
                'multiple' => true,
                ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => '/admin/'.TaxonomyHelper::AJAX_SELECT_URL,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term}; }')
                ],
                //'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(term) { return term.name+":"+term.vocabulary; }'),
                'templateSelection' => new JsExpression('function (term) {var terms = '.TaxonomyHelper::terms2IndexedArray($model->catalog).'; return term.vocabulary?(term.name+":"+term.vocabulary):terms[term.id];}'),

            ],
        ]);
    ?>
    
    <?= $form->field($model, 'terms')->widget(Select2::classname(), [
            'options' => [
                'placeholder' => 'Select terms ...', 
                'multiple' => true,
                ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => '/admin/'.TaxonomyHelper::AJAX_SELECT_URL,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term}; }')
                ],
                //'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(term) { return term.name+":"+term.vocabulary; }'),
                'templateSelection' => new JsExpression('function (term) {var terms = '.TaxonomyHelper::terms2IndexedArray($model->terms).'; return term.vocabulary?(term.name+":"+term.vocabulary):terms[term.id];}'),

            ],
        ]);
    ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'available')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'publish')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
