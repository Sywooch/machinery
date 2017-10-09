<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
//dd($model);
?>

<?php
$form = ActiveForm::begin([
    'action' => \yii\helpers\Url::to(['catalog/search']),
    'id' => 'search-from',
    'method' => 'get',
    'options' => [
            'class' => 'search-form'
    ],
]);
?>

<div class="search-form-inner flexbox just-between">
    <?php /* $form->field($model, 'search',['template' => '{input}'])->widget(\yii\jui\AutoComplete::classname(), [
        'clientOptions' => [
            'source' => ['USA', 'RUS'],
        ],
        'options' => ['class' => 'form-control ui-autocomplete-input', 'placeholder' => 'Я шукаю...']
    ]); */ ?>
        <?= $form->field($model, 'category', ['options' => ['class'=> 'form-group search-type-group']])
            ->dropDownList(
                    ArrayHelper::map($categories, 'id', 'name'),
                    [
                        'prompt'=>Yii::t('app', 'Select...'),
                        'data-placeholder' => Yii::t('app', 'Select...'),
                    ])
            ->label(false); ?>
        <?= $form->field(
                $model,
                'search',
                ['template' => '{input}',
                    'options' => ['class'=>'form-group search-text-group'],
                ])->textInput([
                     'options' =>
                         [
                             'class' => 'form-control ui-autocomplete-input',
                             'placeholder' => Yii::t('app', 'Search'),
                         ]
            ]); ?>
    <div class="form-group search-submit-group">
        <button type="submit" class="btn btn-warning "><i class="fa fa-search"
                                                          aria-hidden="true"></i>
            <span class="bn-search-inner"><b>Search,</b> or press</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="height: 16px">
                <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Sans; fill: #fff;"
                      d="M 14 5 L 14 6 L 14 11 L 6 11 L 5 11 L 5 12 L 5 26 L 5 27 L 6 27 L 26 27 L 27 27 L 27 26 L 27 6 L 27 5 L 26 5 L 15 5 L 14 5 z M 16 7 L 25 7 L 25 25 L 7 25 L 7 13 L 15 13 L 16 13 L 16 12 L 16 7 z M 19 13 L 19 18 L 13.1875 18 L 14.96875 16.21875 L 13.53125 14.78125 L 10.03125 18.28125 L 9.34375 19 L 10.03125 19.71875 L 13.53125 23.21875 L 14.96875 21.78125 L 13.1875 20 L 20 20 L 21 20 L 21 19 L 21 13 L 19 13 z"
                      overflow="visible" font-family="Sans"></path>
            </svg>
        </button>
    </div>
</div>

<?php ActiveForm::end(); ?>

