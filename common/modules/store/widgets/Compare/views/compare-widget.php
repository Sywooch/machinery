<?php

use common\modules\store\widgets\Compare\Asset;

Asset::register($this);
?>
<div id="compare-block-widget" class="sub-widget">
    <a href="/store/compare" class="<?=$count?'active':'';?>">
        <span class="fa fa-balance-scale mif-compare"></span>
        <span class="items-count"><?=$count?></span>
    </a>
</div>