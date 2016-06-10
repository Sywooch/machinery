<?php

use yii\helpers\Html;
use common\modules\cart\Asset as CartAsset;
use common\modules\cart\helpers\CartHelper;
use common\modules\cart\widgets\BuyButtonWidget as BuyButton;


CartAsset::register($this);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-2" id="sub-menu">
        
    </div>
    <div class="col-lg-10 sub-menu__items">
        
        <?php foreach($items as $item):?>
            <div class="category__item">
                <h2><a href="/<?=$item['term']->transliteration?>"><?=$item['term']->name?></a></h2>
                <?php foreach($item['dataProvider']->products as $product):?>
                <div><?php echo Html::a($product->title, ['/'])?></div>
                <div>
                    <?php if(!empty($product->files[0])):?>
                        <?php echo Html::a(Html::img('/'.$product->files[0]->path.'/style/130x130/'.$product->files[0]->name),['/']);?>
                    <?php endif;?>
                </div>
                <div><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></div>
                <div><?php echo BuyButton::widget(['product' => $product]);?></div>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>
        <?=CartHelper::getConfirmModal();?>
    </div>
</div>




