<?php

use yii\helpers\Html;
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;
use common\modules\file\helpers\StyleHelper;
CartAsset::register($this);

$this->title = Html::encode($current->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-2" id="sub-menu">   
    </div>
    <div class="col-lg-10 sub-menu__items">
        <?php foreach($items as $item):?>
            <div class="category__item">
                <h2><a href="/<?=$item['term']->transliteration?>"><?=Html::encode($item['term']->name);?></a></h2>
                <?php foreach($item['products'] as $product):?>
                <div><?php echo Html::a(Html::encode($product->title), ['/' . $product->alias->alias]); ?></div> 
                <div>
                    <?php if(!empty($product->photos[0])):?>
                        <?php echo Html::a(Html::img('/'.StyleHelper::getPreviewUrl($product->files[0], '130x130')),['/product', 'entity' => $product]);?>
                    <?php endif;?>
                </div>
                <div><?php echo Html::encode($product->short); ?></div>
                <div><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></div>
                <div><?php echo CartHelper::getBuyButton($product);?></div>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>
        <?=CartHelper::getConfirmModal();?>
    </div>
</div>




