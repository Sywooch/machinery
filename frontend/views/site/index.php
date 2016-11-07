<?php
use frontend\modules\cart\Asset as CartAsset;

CartAsset::register($this);

$this->title = 'Интернет-магазин №1';

?>
<div class="site-index">
    
    <div class="asd-index">
        <?php if($slider):?>
            <?=$this->render('_slider',['slider' => $slider]);?>
        <?php endif;?>
        <?=$this->render('_actions',['actions' => $actions]);?>
    </div>
    
    
    <div class="btn-group custom" role="group" id="front-tabs-1">
        <a type="button" class="btn btn-default active" href="#" data-tab="tab-top">Топ-100</a>
        <a type="button" class="btn btn-default " href="#" data-tab="tab-discount">Суперцена</a>
    </div>
    
    <?php foreach($models as $index => $products):?>
        <div class="tab-items tab-catalog-category catalog-category <?=($index == 'top')? 'active' : '';?>" id="tab-<?=$index;?>">
            <?php foreach($products as $product):?>
                <?=$this->render('../../modules/catalog/views/default/_itemB',[
                    'product' => $product
                ]);?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    
     <?=$this->render('_reviews',['reviews' => $reviews]);?>
    
</div>

