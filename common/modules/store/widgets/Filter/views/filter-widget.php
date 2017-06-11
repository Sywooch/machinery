<?php
use common\modules\store\widgets\Filter\Asset;

use yii\helpers\Html;
use yii\jui\Slider;
use yii\widgets\ActiveForm;
use common\modules\store\widgets\Filter\helpers\FiltertHelper;

Asset::register($this);

?>

<?php $form = ActiveForm::begin([]); ?>

<div id="filter" class="filter">
    <section class="price-range">
        <span class="h4">Цена</span>

        <div class="price-container">
            <?= Html::textInput('FilterModel[priceMin]', $url->min, ['id' => 'priceMin']) ?>
            <span class="mdash">—</span>

            <?= Html::textInput('FilterModel[priceMax]', $url->max, ['id' => 'priceMax']) ?>
            <span>грн</span>
        </div>
        <div class="price-slider">
            <?= Slider::widget([
                'clientOptions' => [
                    'range' => true,
                    'min' => 0,
                    'max' => 30000,
                    'values' => [3000, 28000],
                    'animate' => true
                ],
                'clientEvents' => [
                    'slide' => 'function(e, ui){
                    $("#priceMin").val(ui.values[0]); $("#priceMax").val(ui.values[1]); 
                }',
                ]
            ]);
            ?>
        </div>



    </section>
    <?php foreach ($vocabularies as $vocabulary): ?>
        <?php if (isset($filterItems[$vocabulary->id])): ?>
            <section class="section-params">
                <span class="h4"><?= $vocabulary->name; ?></span>
                <div>
                    <?php foreach ($filterItems[$vocabulary->id] as $index => $term): ?>
                        <span data-url="/<?= FiltertHelper::link($url, $term); ?>"
                              class="filter-item <?= isset($url->terms[$term['id']]) ? 'active' : ''; ?>"><?= $term['name']; ?></span>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    <?php endforeach; ?>
</div>


<?php ActiveForm::end(); ?>
