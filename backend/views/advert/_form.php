<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\modules\file\widgets\FileInput\FileInputWidget;

use common\modules\file\Asset as FileAsset;

FileAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Advert */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="advert-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <?= $form->field($model, 'lang')->dropDownList(ArrayHelper::map($languages, 'url', 'name')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <div class="col-md-6">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'currency')->textInput() ?>
    </div>


    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manufacture')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'condition')->textInput() ?>

    <?= $form->field($model, 'operating_hours')->textInput() ?>

    <?= $form->field($model, 'mileage')->textInput() ?>

    <?= $form->field($model, 'bucket_capacity')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tire_condition')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'serial_number')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'published')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'maderated')->checkbox() ?>


    <?= $form->field($model, 'photos', ['template' => '{input}{error}'])
        ->widget(FileInputWidget::class, ['showRemove' => true]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
