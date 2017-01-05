<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\helpers\ModelHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

?>

<div class="field-group">
    
    <?= Select2::widget([
            'name' => StringHelper::basename(get_class($field->model)) . '[' .$field->attribute . '][]',
            'value' => ArrayHelper::getColumn($field->model->{$field->attribute}, 'id'),
            'options' => [
                'placeholder' => 'Select terms ...', 
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => '/'. TaxonomyHelper::AJAX_SELECT_URL . '?vocabularyId=' . $field->vocabularyId,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term}; }')
                ],
                'templateResult' => new JsExpression('function(term) { return term.name+":"+term.vocabulary; }'),
                'templateSelection' => new JsExpression('function (term) {var terms = '.TaxonomyHelper::terms2IndexedArray($field->model->{$field->attribute}).';  return term.vocabulary?(term.name+":"+term.vocabulary):terms[term.id];}'),

            ]
        ]);

?>
    
    
    
    
    <?= Html::error($field->model, $field->attribute, ['class' => 'help-block']); ?>

    
</div>
