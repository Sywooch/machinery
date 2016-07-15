<?php
use frontend\modules\catalog\widgets\Filter\Asset;

use yii\helpers\Url;
use frontend\modules\catalog\components\UrlSingleton;
use frontend\modules\catalog\helpers\UrlHelper;

Asset::register($this);

?>
<div id="filter">
    <?php foreach($vocabularies as $vocabulary): ?>
        <?php if(isset($filterItems[$vocabulary->id])):?>
            <h2><?=$vocabulary->name;?></h2>
            <?php foreach($filterItems[$vocabulary->id] as $term): ?>
                <div data-url="<?=Url::to(['', 'filter' => $term]); ?>" class="filter-item"><?=$term->name;?></div>
            <?php endforeach; ?>
        <?php endif;?>
    <?php endforeach; ?>
</div>
