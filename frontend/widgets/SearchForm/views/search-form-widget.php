<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\jui\AutoComplete;

?>


<?php
$form = ActiveForm::begin([
    'id' => 'search-from',
    'method' => 'get',
    'options' => [],
]);
?>


<div class="input-group ">
    <?= $form->field($model, 'search',['template' => '{input}'])->widget(\yii\jui\AutoComplete::classname(), [
        'clientOptions' => [
            'source' => ['USA', 'RUS'],
        ],
        'options' => ['class' => 'form-control ui-autocomplete-input', 'placeholder' => 'Я шукаю...']
    ]); ?>
    <div class="input-group-btn">
        <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>
    </div>
</div>


<?php ActiveForm::end(); ?>

