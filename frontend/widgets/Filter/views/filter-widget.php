<?php

use frontend\helpers\SiteHelper;
use yii\jui\Slider;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;


// Asset::register($this);

?>


<?php
$form = ActiveForm::begin([
    'id' => 'filterForm',
    'method' => 'get',
    'action' => \yii\helpers\Url::to(['/catalog/index']),
//    'options' => ['class' => 'filter-form-inner'],
]);
?>


<div class="row filter-form-row">
    <div class="col-md-4">
        <div class="form-group field-filterform-category">
            <label class="control-label" for=""><?= Yii::t('app', 'Area') ?></label>
            <?= Html::activeDropDownList(
                $model,
                'category',
                ArrayHelper::map($itemsRepository->getVocabularyTopTerms(2), 'id', 'name'),
                [
                    'id' => 'obj-category',
                    'name' => 'category',
                    'class' => 'filter-item form-control select-cascade',
                    'data-url' => \yii\helpers\Url::to(['ajax/categories']),
                    'data-target' => '#obj-subcategory',
//                    'data-type' => 'DropDownListFilter',
//            'options' => $options
                    'prompt' => 'All',
                ]); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group field-filterform-category">
            <label class="control-label" for=""><?= Yii::t('app', 'Category') ?></label>
            <?= Html::activeDropDownList(
                $model,
                'subcategory',
                ArrayHelper::map($subcats, 'id', 'title'),
                [
                    'id' => 'obj-subcategory',
                    'name' => 'subcategory',
                    'class' => 'filter-item form-control',
                    'data-type' => 'DropDownListFilter',
                    'options' => \frontend\helpers\CatalogHelper::optionsForSelect($subcats),
                ]); ?>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group field-filterform-category">
            <label class="control-label" for=""><?= Yii::t('app', 'Manufacturer') ?></label>
            <?= Html::activeDropDownList(
                $model,
                'manufacturer',
                ArrayHelper::map($itemsRepository->getVocabularyTerms(3), 'id', 'name'),
                [
                    'id' => 'obj-manufacturer',
                    'name' => 'manufacturer',
                    'class' => 'filter-item form-control',
                    'data-type' => 'DropDownListFilter',
                    'prompt' => Yii::t('app', 'All'),
                ]); ?>
        </div>
    </div>
</div>
<div class="row filter-form-row">
    <div class="col-md-4">
        <div class="form-group field-filterform-category">
            <label class="control-label" for=""><?= Yii::t('app', 'Model') ?></label>
            <?= Html::activeTextInput($model, 'model', [
                'id' => 'obj-model',
                'name' => 'model',
                'class' => 'filter-item form-control',
            ]) ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group field-filterform-price">

            <?php
            $valMinPrice = $model->price['min'] ? $model->price['min'] : $priceMin;
            $valMaxPrice = $model->price['max'] ? $model->price['max'] : $priceMax;
            ?>
            <?= Html::activeHiddenInput($model, 'price[min]', ['id' => 'filterform-price-min', 'name' => 'price[min]']) ?>
            <?= Html::activeHiddenInput($model, 'price[max]', ['id' => 'filterform-price-max', 'name' => 'price[max]']) ?>
            <label for="">Price (EUR):</label>
            <?php echo Slider::widget([
                'clientOptions' => [
                    'range' => true,
                    'min' => $priceMin, // минимально возможная цена
                    'max' => $priceMax, // максимально возможная цена
                    'values' => [$valMinPrice, $valMaxPrice], // диапазон по умолчанию
                    'step' => 10,
                    'animate' => true

                ],
                'id' => 'price-slider',
                'clientEvents' => [
                    'create' => 'function(event, ui){
                     $(".ui-slider-handle").each(function(idx, el){
                        $(el).append($("<span id=\'handler-"+idx+"\' class=\'handler-inner handler-"+idx+"\' />"));
                     });
                     var valMinPrice = ' . $valMinPrice . ';
                     var valMaxPrice = ' . $valMaxPrice . ';
                     $("#handler-0, #op-left-text").text(valMinPrice);
                     $("#handler-1, #op-right-text").text(valMaxPrice); 
                    }',
                    'slide' => 'function(event, ui){
                        //changeSlider(ui)
                        //overPrice();
                    }',
                    'change' => 'function( event, ui){
                $("#filterform-price-min").val(ui.values[0]);
                $("#filterform-price-max").val(ui.values[1]);
                $("#handler-0, #op-left-text").text(ui.values[0]);
                $("#handler-1, #op-right-text").text(ui.values[1]);
       
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
                    <span id="op-left-text"><?= $valMinPrice ?></span> </span>-<span
                        class="op-right">
                    <span id="op-right-text"><?= $valMaxPrice ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php
        for ($i = date('Y'); $i >= 1970; $i--) {
            $years[$i] = $i;
        }
        //        $years['-1970'] = Yii::t('app', 'Before 1973');
        ?>
        <div class="form-group field-filterform-country">
            <label class="control-label" for=""><?= Yii::t('app', 'Year of manufacture from') ?></label>
            <?= Html::activeDropDownList(
                $model,
                'year',
                $years,
                [
                    'id' => 'obj-year',
                    'name' => 'year',
                    'class' => 'filter-item form-control',
                    'data-type' => 'DropDownListFilter',
                    'prompt' => Yii::t('app', 'All'),
                ]); ?>
        </div>
        <? // $form->field($model, 'year')->dropDownList($years, ['prompt' => 'All']) ?>
    </div>
</div>
<div class="row filter-form-row">
    <div class="col-md-4">
        <div class="form-group field-filterform-country">
            <label class="control-label" for=""><?= $model->getAttributeLabel('country') ?></label>
            <?= Html::activeDropDownList(
                $model,
                'country',
                ArrayHelper::map($itemsRepository->getVocabularyTerms(4), 'id', 'name'),
                [
                    'id' => 'obj-country',
                    'name' => 'country',
                    'class' => 'filter-item form-control',
                    'data-type' => 'DropDownListFilter',
                    'prompt' => Yii::t('app', 'All'),
                ]); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group field-filterform-country">
            <label class="control-label" for=""><?= $model->getAttributeLabel('id') ?></label>
            <?= Html::activeTextInput($model, 'id', [
                'id' => 'obj-id',
                'name' => 'id',
                'class' => 'filter-item form-control',
            ]) ?>
        </div>
    </div>
</div>
<div class="row filter-form-row filter-action">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-warning btn-lg"><?= Yii::t('app', 'Show results') ?> <span
                    id="filter-count-result">(17 568)</span>
        </button>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="dots-filter-slider"></div>
<?php //frontend\widgets\Filter\Asset::register($this) ?>
