<?php

use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\StringHelper;
use yii\jui\AutoComplete;

?>

<div class="field-group">

    <input type="hidden" value="<?=$field->model->{$field->attribute}?>" name="<?=StringHelper::basename(get_class($field->model))?>[<?= $field->attribute; ?>]" id="group-id">

    <?= AutoComplete::widget([
        'name' => 'group',
        'clientOptions' => [
            'source' => Url::toRoute('/store/product/find-ajax'),
            'dataType' => 'json',
            'autoFill' => true,
            'minLength' => '2',
            'select' => new JsExpression("function(event, ui) {
                    
                     $('#group-id').val(ui.item.id);

                    }"),
        ],
        'options' => [
            'class' => 'form-control',
            'placeholder' => $entity ? $entity->title :'Поиск...'
        ]
    ]);
    ?>
</div>
