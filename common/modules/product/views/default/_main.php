<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\modules\cart\Asset as CartAsset;
use common\modules\file\helpers\StyleHelper;
use common\modules\product\Asset as ProductAsset;
use common\modules\product\helpers\ProductHelper;
use yii2mod\bxslider\BxSlider;

ProductAsset::register($this);
CartAsset::register($this);

?>
<div class="produt-gallery">
    <?php
    $items = [];
    foreach($model->files as $file){
        $items[] =  Html::img('/'.StyleHelper::getPreviewUrl($file, '700x700'),['class' => 'img-responsive']); 
    }

    echo BxSlider::widget([
        'pluginOptions' => [
            'maxSlides' => 1,
            'speed' => 300,
            'controls' => true,
            'slideWidth' => 450,
            //'adaptiveHeight' => true,
            'pagerCustom' => '#bx-pager',
            'onSliderLoad' => new yii\web\JsExpression('
                function() {

                },
            ')
         ],
        'items' => $items 
     ]); 

    ?>


    <div id="bx-pager">
        <?php foreach($model->files as $index => $file):?>
            <a data-slide-index="<?=$index?>" href=""> <?=Html::img('/'.StyleHelper::getPreviewUrl($file, '100x100'),[]); ?></a>
        <?php endforeach; ?>
    </div>
</div>
<div class="produt-short">
    <?=Html::encode($model->specification);?>
</div>

<div class="body ">
    <?=
    HtmlPurifier::process($model->description, [
        'HTML.AllowedElements' => ['p', 'br', 'b', 'ul', 'li'],
        'AutoFormat.AutoParagraph' => true
    ]);
    ?>
</div>


<div class="characteristic">
    <?php foreach($model->feature as $name => $features):?>
    <h3><?=$name?></h3>
    <ul class="">
        <?php foreach($features as $items):?>
        <li class="">
            <span class="label"><?=$items->name?></span>
            <span><?=$items->value?></span>
        </li> 
        <?php endforeach;?>
    </ul> 
    <?php endforeach;?>
</div>