<?php

use common\modules\cart\Asset as CartAsset;
use common\modules\cart\helpers\CartHelper;

CartAsset::register($this);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-2">
        
    </div>
    <div class="col-lg-10">
        <?php foreach($dataProvider->items as $item):?>
            <?=$item['title'];?>
            <?=CartHelper::getBuyButton($item['id'], $catalogId);?>
        <?php endforeach; ?>
        <?=CartHelper::getConfirmModal();?>
    </div>
</div>




