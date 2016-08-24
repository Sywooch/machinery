<?php
use frontend\modules\catalog\widgets\Filter\Asset;

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\catalog\helpers\FilterHelper;
use kartik\slider\Slider;
use yii\widgets\ActiveForm;

Asset::register($this);

?>

 <?php $form = ActiveForm::begin([]); ?>

<div id="filter" class="filter">
    <section class="price-range">
        <span class="h4">Цена</span>
        <?=Html::textInput ( 'FilterModel[priceMin]', $filter->priceMin , ['id' => 'priceMin'])?>
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
        <?=Html::textInput ( 'FilterModel[priceMax]', $filter->priceMax, ['id' => 'priceMax'] )?>  грн      
    </section>
    <?php foreach($vocabularies as $vocabulary): ?>
        <?php if(isset($filterItems[$vocabulary->id])):?>
            <section  class="section-params">
                <span class="h4"><?=$vocabulary->name;?></span>
                <div>
                    <?php foreach($filterItems[$vocabulary->id] as $index => $term): ?>
                        <span data-url="<?=Url::toRoute(['/catalog', 'term' => $term]); ?><?=Url::toRoute(['/filter', 'term' => $term]); ?>" class="filter-item <?=FilterHelper::isActive($filter,$term)?'active':'';?>"><?=$term->name;?></span>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif;?>
    <?php endforeach; ?>
</div>


<?php ActiveForm::end(); ?>
