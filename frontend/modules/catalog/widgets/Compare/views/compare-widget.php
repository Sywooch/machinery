<?php

use frontend\modules\catalog\widgets\Compare\Asset;
use common\helpers\ModelHelper;

Asset::register($this);
?>
<div id="compare-block-widget" class="sub-widget">
    <a href="/catalog/compare" class="<?=$count?'active':'';?>">
        <span class="mif-compare"></span> 
        <span class="items-count"><?=$count?></span>
    </a>
</div>