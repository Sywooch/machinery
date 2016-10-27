<?php

use frontend\modules\catalog\widgets\Wish\Asset;
use common\helpers\ModelHelper;
use frontend\modules\catalog\helpers\CatalogHelper;

Asset::register($this);
?>
<div id="wish-block-widget" class="sub-widget">
    <a href="/user/<?=Yii::$app->user->id?>/wish" class="<?=$count?'active':'';?>">
        <span class="mif-compare"></span> 
        <span class="items-count"><?=$count?></span>
    </a>
</div>