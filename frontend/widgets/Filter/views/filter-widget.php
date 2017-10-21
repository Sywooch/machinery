<?php

use frontend\helpers\SiteHelper;
use yii\jui\Slider;
use yii\widgets\ActiveForm;


// Asset::register($this);

?>


<?php
$form = ActiveForm::begin([
    'id' => 'filter-from',
    'method' => 'get',
    'action' => '/catalog/index',
    'options' => ['class' => 'filter-form-inner'],
]);
?>


<div class="row filter-form-row">
    <div class="col-md-4">
        <?= $form->field($model, 'area')->dropDownList(\yii\helpers\ArrayHelper::map($itemsRepository->getVocabularyTerms(1), 'id', 'name'), ['prompt' => 'All']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'category')->dropDownList(\yii\helpers\ArrayHelper::map($itemsRepository->getVocabularyTerms(2), 'id', 'name'), ['prompt' => 'All']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'manufacturer')->dropDownList(\yii\helpers\ArrayHelper::map($itemsRepository->getVocabularyTerms(3), 'id', 'name'), ['prompt' => 'All']) ?>
    </div>
</div>
<div class="row filter-form-row">
    <div class="col-md-4">
        <?= $form->field($model, 'model')->textInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'price[min]',['template' => '{input}'])->hiddenInput() ?>
        <?= $form->field($model, 'price[max]',['template' => '{input}'])->hiddenInput() ?>
        <label for="">Price (EUR):</label>
        <?php
        echo Slider::widget([
            'clientOptions' => [
                'range' => true,
                'min' => 10, // минимально возможная цена
                'max' => 10000, // максимально возможная цена
                'values' => [$model->price['min'], $model->price['max']], // диапазон по умолчанию
                'step' => 10,
                'animate' => true

            ],
            'clientEvents' => [
                'create' => 'function(event, ui){
                       
                        $(".ui-slider-handle").attr("title", "Это бегунок цены, двигай его, мы покажем варианты.");
                        
                    }',
                'slide' => 'function(event, ui){
                        //changeSlider(ui)
                        //overPrice();
                    }',
                'change' => 'function( event, ui){
                $("#filterform-price-min").val(ui.values[0]);
                $("#filterform-price-max").val(ui.values[1]);
       
                        //changeSlider(ui)
                        //overPrice();
                    }',
                'stop' => 'function( event, ui){
                    
                        if(typeof priceSlideStop != "undefined"){
                            //priceSlideStop(event, ui);
                        }

                    }',

            ]
        ]);
        ?>
        <div id="over-price" class="over-price">
                <span class="op-left">
                    <span id="op-left-text">0</span> </span>-<span
                    class="op-right">
                    <span id="op-right-text">200</span>
        </div>
    </div>
    <div class="col-md-4">
        <?php
        for ($i = date('Y'); $i >=1970; $i--) {
            $years[$i] = $i;
        }
        ?>
        <?= $form->field($model, 'year')->dropDownList($years, ['prompt' => 'All']) ?>
    </div>
</div>
<div class="row filter-form-row">
    <div class="col-md-4">
        <?= $form->field($model, 'country')->dropDownList(\yii\helpers\ArrayHelper::map($itemsRepository->getVocabularyTerms(4), 'id', 'name'), ['prompt' => 'All']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'id')->textInput() ?>
    </div>
</div>
<div class="row filter-form-row filter-action">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-warning btn-lg">Show results <span id="filter-count-result">(17 568)</span>
        </button>
    </div>
</div>
<?php ActiveForm::end(); ?>


