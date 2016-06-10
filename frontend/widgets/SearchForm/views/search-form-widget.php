<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

?>


    <?php
    $form = ActiveForm::begin([
                'id' => 'search-from',
                'method' => 'get',
                'options' => [],
    ]);
    ?>
    
    <?= $form->field($model, 'search', ['template' => '{input}'])->widget(Select2::classname(), [
            'options' => [
                'placeholder' => 'Поиск', 
                'multiple' => false,
               
                ],
            'size' => Select2::SMALL,   
            'showToggleAll' => false,
            'addon' =>[
                'prepend' => [
                    'content' => '<span class="glyphicon glyphicon-search"></span>',
                    'asButton' => false
                ],
                'append' => [
                    'content' => Html::submitButton('', [
                            'class' => 'btn btn-default glyphicon glyphicon-menu-right',
                            'title' => 'Поиск',
                        ]),
                    'asButton' => true
                ]
            ], 
            'pluginOptions' => [
                
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => '/admin/',
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {name:params.term}; }')
                ], 
            ],
        ]);
    ?>


    <?php ActiveForm::end(); ?>

