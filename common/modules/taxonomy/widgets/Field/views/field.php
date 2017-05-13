<?php

use kartik\select2\Select2;
use yii\web\JsExpression;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


$name = StringHelper::basename(get_class($field->model)) . '[' . $field->attribute . ']';
$data = $field->model->{$field->attribute} ? ArrayHelper::getColumn($field->model->{$field->attribute}, 'id') : [];

?>

<div class="field-group">

    <input type="hidden" value="<?= implode(',', $data); ?>" name="<?= $name; ?>">

    <?= Select2::widget([
        'name' => 's' . time(),
        'value' => $data,
            'options' => [
                'placeholder' => 'Select terms ...',
                'multiple' => true,
            ],
        'pluginEvents' => [
            "change" => "function() { var value = $(this).val() ?  $(this).val().join(',') : '';  $('input[name=\"$name\"]').val($(this).val());  }",
        ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 0,
                'ajax' => [
                    'url' => '/taxonomy/items/terms-ajax' . ($field->vocabularyId ? '?vocabularyId=' . $field->vocabularyId : ''),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term}; }')
                ],
                'templateResult' => new JsExpression('function(term) { return term.name+":"+(term.vocabulary ? term.vocabulary.name:""); }'),
                'templateSelection' => new JsExpression('function (term) {var terms = ' . TaxonomyHelper::terms2IndexedArray($field->model->{$field->attribute} ? $field->model->{$field->attribute} : []) . ';  return term.vocabulary?(term.name+":"+(term.vocabulary ? term.vocabulary.name:"")):terms[term.id];}'),

            ]
        ]);
    ?>

</div>
