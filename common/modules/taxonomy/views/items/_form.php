<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\modules\taxonomy\models\TaxonomyItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="taxonomy-items-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'transliteration')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pid')->widget(Select2::classname(), [

            'options' => ['placeholder' => 'Select a parent ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => 'terms-ajax',
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {exeptId:"'.$model->id.'", vid:"'.$model->vid.'",name:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(term) { return term.name; }'),
                'templateSelection' => new JsExpression('function (term) { return term.name?term.name:"'.$parentTerm->name.'"; }'),
            ],
        ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
