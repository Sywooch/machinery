<?php
use common\modules\taxonomy\helpers\TaxonomyHelper;
use frontend\modules\catalog\widgets\CatalogMenu\CatalogMenuWidget;
use frontend\modules\catalog\widgets\CatalogMenu\Asset;
use yii\helpers\Html;
use frontend\modules\catalog\helpers\CatalogHelper;
Asset::register($this);


?>

<div class="wide nav-menu-expanded" id="catalog-menu">

    <div id="layout">
        <div class="main-navigation">
            <a href="/" class="logo"><img src="/images/logo.png"></a>
            <ul class="main-navigation__inner">
                <?php foreach($menuItems as $index => $mainItem):?>
      
                <li class="menu-item menu-item_expandable menu-item_products menu-item_cat_<?=$mainItem['id'];?>  ">
                    <span class="menu-item__link-container">
                        <a href="/<?=CatalogHelper::link([$mainItem]);?>" class="link_side-menu"><?=$mainItem['name']?></a>
                    </span>
                    <?php if(isset($mainItem['children'])):?>
                        <?php
                            $childrens = TaxonomyHelper::nes2Flat($mainItem['children']);
                            $childrensCount = count($childrens);
                            $chunkCount = $columnsCount = ceil ($childrensCount / CatalogMenuWidget::MAX_ITEMS_IN_COLUMN);
                            $columnsCount = max($columnsCount, 1);
                        ?>
                        <div class="subcategory-list subcategory-list_products " style=" column-count: <?=$columnsCount;?>; -moz-column-count: <?=$columnsCount;?>; min-width: <?=($columnsCount*250);?>px; top: 0px;"> 
                            <?php foreach($childrens as $childrenItem):?>
                                <div class="subcategory-list-item ">
                                    <?php if($mainItem['id'] == $childrenItem['pid']):?>
                                        <span class="h3 subcategory-list-item__link-title  ">
                                            <a href="/<?=CatalogHelper::link([$mainItem, $childrenItem]);?>" class="subcategory-list-item__link"><?=$childrenItem['name']?></a>
                                        </span>
                                    <?php else: ?>
                                        <div class="subcategory-list-item__link-title_level2">
                                            <a href="/<?=CatalogHelper::link([$mainItem, $childrenItem]);?>" class="subcategory-list-item__link"><?=$childrenItem['name']?></a>
                                        </div>
                                    <?php endif; ?>
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