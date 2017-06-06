<?php
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\store\widgets\CatalogMenu\CatalogMenuWidget;
use common\modules\store\widgets\CatalogMenu\Asset;
use common\modules\store\helpers\CatalogHelper;
Asset::register($this);

?>


<div class="wide nav-menu-expanded" id="catalog-menu">

    <div id="layout">
        <div class="main-navigation">
            <!--a href="/" class="logo"><img src="/images/logo.png"></a-->
            <ul class="main-navigation__inner">
                <?php foreach($menuItems as $index => $mainItem):?>
      
                <li class="menu-item menu-item_expandable menu-item_products menu-item_cat_<?=$mainItem->id;?>  ">
                    <span class="menu-item__link-container">
                        <a href="/<?=CatalogHelper::link([$mainItem]);?>" class="link_side-menu"><?=$mainItem->name?></a>
                    </span>
                    <?php if(!empty($mainItem->childrens)):?>
                        <?php
                            $childrensCount = TaxonomyHelper::countChildren($mainItem);
                            $chunkCount = $columnsCount = ceil ($childrensCount / CatalogMenuWidget::MAX_ITEMS_IN_COLUMN);
                            $columnsCount = max($columnsCount, 1);
                        ?>
                        <div class="subcategory-list subcategory-list_products " style=" column-count: <?=$columnsCount;?>; -moz-column-count: <?=$columnsCount;?>; min-width: <?=($columnsCount*250);?>px; top: 0px;"> 
                            <?php foreach($mainItem->childrens as $childrenItem):?>
                                <div class="subcategory-list-item ">

                                    <span class="subcategory-list-item__link-title  ">
                                        <a href="/<?=CatalogHelper::link([$mainItem, $childrenItem]);?>" class=""><?=$childrenItem->name?></a>
                                    </span>
                                    <?php foreach($childrenItem->childrens as $childrenItem2):?>

                                        <div class="subcategory-list-item__link-title_level2">
                                            <a href="/<?=CatalogHelper::link([$mainItem, $childrenItem2]);?>" class="subcategory-list-item__link"><?=$childrenItem2->name?></a>
                                        </div>

                                    <?php endforeach;?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>  
                </li>
                <?php endforeach;?>
               </ul>
        </div>
    </div>
</div>