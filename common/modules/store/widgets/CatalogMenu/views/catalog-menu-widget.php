<?php
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\store\widgets\CatalogMenu\CatalogMenuWidget;
use common\modules\store\widgets\CatalogMenu\Asset;
use common\modules\store\helpers\CatalogHelper;

Asset::register($this);

?>
<nav class="main-nav  ">
    <div class="mobile-nav__bg "></div>
    <div class="container">
        <ul class="menu align-justify">
            <?php foreach ($menuItems as $index => $mainItem): ?>
                <li class="main-nav__item   ">
                    <a class="icon" href="/ua/actions/?section%5B%5D=5340">
                        <?=$mainItem->name?>
                        <!--div class="sale-count-wrapper"><span class="sale-count">271</span></div-->

                    </a>
                    <?php if (!empty($mainItem->childrens)): ?>
                    <ul class="secondary-nav row ">

                        <?php foreach($mainItem->childrens as $childrenItem):?>

                        <li class="col-lg-3 sub-item">
                            <a href="/ua/actions/?section%5B%5D=5337">
                                <div class="row secondary-nav__item">
                                    <div class="col-lg-9 item-text"><?=$childrenItem->name?></div>
                                    <div class="col-lg-3"><img src="//27.ua//upload/uf/b38/01_sale_02_min.jpg" alt=""></div>
                                </div>
                            </a>
                        </li>

                        <?php endforeach;?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <!--div class="main-nav__more show-for-newxlarge mainNavItemMoreJS">
            <a class="icon-more-arrow"> Ще </a>
        </div-->
    </div>
</nav>
