<?php
use common\modules\taxonomy\helpers\TaxonomyHelper;
use frontend\modules\catalog\widgets\CatalogMenu\CatalogMenuWidget;
use frontend\modules\catalog\widgets\CatalogMenu\Asset;
use yii\helpers\Html;

Asset::register($this);

?>

<div class="wide nav-menu-expanded" id="catalog-menu">
    <div id="layout">
        <div class="main-navigation">
            <ul class="main-navigation__inner">
                <?php foreach($menuItems as $index => $mainItem):?>
                <li class="menu-item menu-item_expandable menu-item_products menu-item_cat_phones  ">
                    <span class="menu-item__link-container   phones">
                        <span class="menu-item__link-container-inner">
                            <?=Html::a($mainItem['name'], ['/catalog', 'menu' => [$mainItem]], ['class'=> 'link_side-menu']);?>
                        </span>
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
                                            <?=Html::a($childrenItem['name'], ['/catalog','menu' => [$mainItem, $childrenItem]], ['class'=> 'subcategory-list-item__link']);?>
                                        </span>
                                    <?php else: ?>
                                        <div class="subcategory-list-item__link-title_level2">
                                            <?=Html::a($childrenItem['name'], ['/catalog','menu' => [$mainItem, $childrenItem]], ['class'=> 'subcategory-list-item__link']);?>
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