<?php

use common\modules\store\widgets\Wish\Asset;

Asset::register($this);
?>
<div id="wish-block-widget" class="sub-widget">
    <a href="/user/<?=Yii::$app->user->id?>/wish" class="<?=$count?'active':'';?>">
        <span class="fa fa-heart-o mif-compare"></span>
        <span class="items-count"><?=$count?></span>
    </a>
</div>