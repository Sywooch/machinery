<?php
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\store\widgets\CatalogMenu\CatalogMenuWidget;
use common\modules\store\widgets\CatalogMenu\Asset;
use common\modules\store\helpers\CatalogHelper;

Asset::register($this);

?>
<nav class="main-nav">
    <div class="container">
        <ul class="menu align-justify">
            <?php foreach ($menuItems as $index => $mainItem): ?>
                <li class="main-nav__item  ">
                    <a href="/" class="<?=$index == 11 ? 'active' : ''?>">
                        <?=$mainItem->name?>
                    </a>
                    <?php if (!empty($mainItem->childrens)): ?>
                    <ul class="secondary-nav row ">

                        <?php foreach($mainItem->childrens as $childrenItem):?>

                        <li class="col-lg-3 sub-item">
                            <a href="/">
                                <?=$mainItem->name?>
                            </a>
                        </li>

                        <?php endforeach;?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
