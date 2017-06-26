<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\modules\file\widgets\FileInput\FileInputWidget;
use common\modules\file\Asset as FileAsset;

FileAsset::register($this);

?>

<div class="taxonomy-items-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php foreach ($languages as $key => $language): ?>
        <?= $form->field($model, 'translations[' . $key . ']')->textInput()->label($language); ?>
    <?php endforeach; ?>
    <?= $form->field($model, 'transliteration')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pid')->widget(Select2::classname(), [

        'options' => ['placeholder' => 'Select a parent ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'ajax' => [
                'url' => 'terms-ajax',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {excludedId:"' . $model->id . '", vocabularyId:"' . $model->vid . '", name:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(term) { return term.name; }'),
            'templateSelection' => new JsExpression('function (term) { return term.name?term.name:"' . $parentTerm->name . '"; }'),
        ],
    ]);
    ?>

    <?= $form->field($model, 'icon', ['template' => '{input}{error}'])->widget(FileInputWidget::class, ['showRemove' => true]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
