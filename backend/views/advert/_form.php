<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\modules\file\widgets\FileInput\FileInputWidget;
use common\models\Currency;
use kartik\select2\Select2;
use common\modules\taxonomy\helpers\TaxonomyHelper;

use yii\jui\DatePicker;

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
    <div class="col-md-6">
        <?= $form->field($model, 'lang')->dropDownList(ArrayHelper::map($languages, 'url', 'name')) ?>
    </div>
    <div class="col-md-6">
        <?php foreach ($languages as $lang): ?>
            <a href="#"><?= $lang->name ?></a>
        <?php endforeach; ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'currency')
            ->dropDownList(ArrayHelper::map(
                    Currency::find()->where(['active'=>Currency::STATUS_ACTIVE])->all(), 'id', 'name'),
                [ 'prompt'=>'- Select currency -']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'category')
            ->widget(Select2::classname(), [
            'data' => TaxonomyHelper::terms3Level($categories),
            'options' => ['placeholder' => Yii::t('app', '- Select category -'), 'size'=>2],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
                'maximumInputLength' => 15,
                'tags' => true,
                'maximumSelectionLength' => 2,
            ],
            'showToggleAll' => false,
        ]); ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'manufacture')
            ->dropDownList(\yii\helpers\ArrayHelper::map(
                $manufacturer,'id','name'),
                [ 'prompt'=>'- Select manufacture -']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'year')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'condition')->textInput() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6"><?= $form->field($model, 'operating_hours')->textInput() ?></div>

    <div class="col-md-6"><?= $form->field($model, 'mileage')->textInput() ?></div>

    <div class="col-md-12"><?= $form->field($model, 'bucket_capacity')->textarea(['rows' => 6]) ?></div>

    <div class="col-md-12"><?= $form->field($model, 'tire_condition')->textarea(['rows' => 6]) ?></div>

    <div class="col-md-12"><?= $form->field($model, 'serial_number')->textarea(['rows' => 6]) ?></div>

    <div class="col-md-6">
        <? //= $form->field($model, 'created')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'created')->widget(\yii\jui\DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
        ]) ?>
    </div>

    <div class="col-md-6">
        <? //= $form->field($model, 'updated')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'updated')->widget(\yii\jui\DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
        ]) ?>
    </div>

    <div class="col-md-6">
        <? //= $form->field($model, 'published')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'published')->widget(\yii\jui\DatePicker::classname(), [
            //'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
        ]) ?>
    </div>

    <div class="col-md-6"><?= $form->field($model, 'status')->checkbox() ?></div>

    <div class="col-md-6"><?= $form->field($model, 'maderated')->checkbox() ?></div>

    <?= $form->field($model, 'photos', ['template' => '{input}{error}'])
        ->widget(FileInputWidget::class, ['showRemove' => true]); ?>

    <?= $form->field($model, 'meta_description')->textarea(['col']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php /*echo $this->registerJs('
        $(function(){
            $(\'#advert-created\').datepicker();
        })
    ') */ ?>


</div>
