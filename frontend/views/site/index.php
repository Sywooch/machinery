<?php
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;

CartAsset::register($this);

$this->title = 'Интернет-магазин №1';

?>
<div class="site-index">
    
    <div class="asd-index">
        <?=$this->render('_slider',['slider' => $slider]);?>
        <?=$this->render('_actions',['actions' => $actions]);?>
    </div>
    
    <div class="btn-group custom" role="group" id="front-tabs-1">
        <?php foreach($terms as $term):?>
            <a type="button" class="btn btn-default <?=($term->id == 1095)? 'active' : '';?>" href="#" data-tab="tab-<?=$term->id;?>"><?=$term->name?></a>
        <?php endforeach; ?>
    </div>
    <?php foreach($models as $index => $products):?>
        <div class="tab-items tab-catalog-category catalog-category <?=($index == 1095)? 'active' : '';?>" id="tab-<?=$index;?>">
            <?php foreach($products as $product):?>
                <?=$this->render('../../modules/catalog/views/default/_itemB',[
                    'product' => $product
                ]);?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    
     <?=$this->render('_reviews',['reviews' => $reviews]);?>
    
</div>
<?=CartHelper::getConfirmModal();?>  

