<?php
use common\modules\store\widgets\Filter\Asset;

use yii\helpers\Html;
use kartik\slider\Slider;
use yii\widgets\ActiveForm;
use common\modules\store\widgets\Filter\helpers\FiltertHelper;

Asset::register($this);

?>

 <?php $form = ActiveForm::begin([]); ?>

<div id="filter" class="filter">
    <section class="price-range">
        <span class="h4">Цена</span>
        <?=Html::textInput ( 'FilterModel[priceMin]', $url->min , ['id' => 'priceMin'])?>
        <?=$form->field($model, 'priceRange',['template' => '{input}{error}'])->widget(Slider::classname(), [
            'pluginOptions'=>[
                'min' => 0,
                'max' => 30000,
                'step' => 5
            ],
            'pluginEvents'=>[
                "slide" => "function(e,b) { $('#priceMin').val(e.value[0]); $('#priceMax').val(e.value[1]);  }",
            ]
        ]);
        ?>
        <?=Html::textInput ( 'FilterModel[priceMax]', $url->max, ['id' => 'priceMax'] )?>  грн      
    </section>
    <?php foreach($vocabularies as $vocabulary): ?>
        <?php if(isset($filterItems[$vocabulary->id])):?>
            <section  class="section-params">
                <span class="h4"><?=$vocabulary->name;?></span>
                <div>
                    <?php foreach($filterItems[$vocabulary->id] as $index => $term): ?>
                        <span data-url="/<?=FiltertHelper::link($url, $term);?>" class="filter-item <?=isset($url->terms[$term->id]) ? 'active':'';?>"><?=$term->name;?></span>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif;?>
    <?php endforeach; ?>
</div>


<?php ActiveForm::end(); ?>
