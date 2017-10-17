<?php
/**
 * @var categories
 * @var last_adverts
 */

use frontend\widgets\Filter\FilterWidget;
use yii\helpers\Url;
$this->title = 'Machinery park';

?>
<div class="site-index">
    <div class="main-filter-wrap">
        <div class="slider-main-block">
            <div class="slider-block">
                <div class="slide"><img src="/images/slide-1.png" alt=""></div>
                <div class="slide"><img src="/images/slide-2.png" alt=""></div>
            </div>
        </div>
        <div class="container filter-main-container">
            <div class="row filter-row">
                <div class="col-md-8 pull-right block-filter-main">
                    <?= FilterWidget::widget(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <?= \frontend\widgets\AdsBanners\AdsBannersWidget::widget(['region'=>'right-sidebar'])?>
            </div>
            <div class="col-md-8 col-lg-8">
                <?php if($categories): ?>
<!--                    --><?php //dd($categories) ?>

                <div class="list-categories flexbox just-around flex-wrap">
                    <?php foreach ($categories as $key => $category): ?>
                        <div class="item-cat cat-<?= $category->icon_name ?>" data-cat="<?= $category->icon_name ?>">
                            <a href="<?= Url::to(['/catalog', 'category'=> $category->transliteration]) ?>" class="cat-link">
                                <span class="_count">2150</span>
                                <span class="_img img-cat img-cat-<?= $category->icon_name ?>">
                                    <img src="/images/cat1.png" alt="">
                                    <img src="/images/cat1-hov.png" alt="">
                                </span>
                                <span class="_title"><?= $category->name ?></span></a>
                        </div>
                    <?php endforeach; ?>
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">2150</span><span class="_img">-->
<!--                        <img src="/images/cat1.png" alt="">-->
<!--                        <img src="/images/cat1-hov.png" alt="">-->
<!--                        </span><span class="_title">Industrial machinery</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">45231</span><span class="_img">-->
<!--                        <img src="/images/cat2.png" alt="">-->
<!--                        <img src="/images/cat2-hov.png" alt="">-->
<!--                        </span><span class="_title">Cranes</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">21213</span><span class="_img">-->
<!--                        <img src="/images/cat3.png" alt="">-->
<!--                        <img src="/images/cat3-hov.png" alt="">-->
<!--                        </span><span class="_title">Forestry machinery </span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">1099</span><span class="_img">-->
<!--                        <img src="/images/cat4.png" alt="">-->
<!--                        <img src="/images/cat4-hov.png" alt="">-->
<!--                        </span><span class="_title">Attachments</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">1099</span><span class="_img">-->
<!--                        <img src="/images/cat5.png" alt="">-->
<!--                        <img src="/images/cat5-hov.png" alt="">-->
<!--                        </span><span class="_title">Forklifts</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">65</span><span class="_img">-->
<!--                        <img src="/images/cat6.png" alt="">-->
<!--                        <img src="/images/cat6-hov.png" alt="">-->
<!--                        </span><span class="_title">Agricultural machinery</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">65</span><span class="_img">-->
<!--                        <img src="/images/cat7.png" alt="">-->
<!--                        <img src="/images/cat7-hov.png" alt="">-->
<!--                        </span><span class="_title">Recycling / Processing plants</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">65</span><span class="_img">-->
<!--                        <img src="/images/cat8.png" alt="">-->
<!--                        <img src="/images/cat8-hov.png" alt="">-->
<!--                        </span><span class="_title">Trailers / Semitrailers</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">65</span><span class="_img">-->
<!--                        <img src="/images/cat9.png" alt="">-->
<!--                        <img src="/images/cat9-hov.png" alt="">-->
<!--                        </span><span class="_title">Containers</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">128</span><span class="_img">-->
<!--                        <img src="/images/cat10.png" alt="">-->
<!--                        <img src="/images/cat10-hov.png" alt="">-->
<!--                        </span><span class="_title">Spare parts</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">128</span><span class="_img">-->
<!--                        <img src="/images/cat11.png" alt="">-->
<!--                        <img src="/images/cat11-hov.png" alt="">-->
<!--                        </span><span class="_title">Engines</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">128</span><span class="_img">-->
<!--                        <img src="/images/cat12.png" alt="">-->
<!--                        <img src="/images/cat12-hov.png" alt="">-->
<!--                        </span><span class="_title">Utility vehicles</span></a></div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">2514</span><span class="_img">-->
<!--                        <img src="/images/cat13.png" alt="">-->
<!--                        <img src="/images/cat13-hov.png" alt="">-->
<!--                        </span><span class="_title">Municipal vehicles</span></a>-->
<!--                    </div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">2514</span><span class="_img">-->
<!--                        <img src="/images/cat14.png" alt="">-->
<!--                        <img src="/images/cat14-hov.png" alt="">-->
<!--                        </span><span class="_title">Work platforms</span></a>-->
<!--                    </div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">2514</span><span class="_img">-->
<!--                        <img src="/images/cat15.png" alt="">-->
<!--                        <img src="/images/cat15-hov.png" alt="">-->
<!--                        </span><span class="_title">Construction machinery </span></a>-->
<!--                    </div>-->
<!--                    <div class="item-cat">-->
<!--                        <a href="#"><span class="_count">2514</span><span class="_img">-->
<!--                        <img src="/images/cat16.png" alt="">-->
<!--                        <img src="/images/cat16-hov.png" alt="">-->
<!--                        </span><span class="_title">Construction equipment</span></a>-->
<!--                    </div>-->
<!--                    <div class="item-cat other-cat">-->
<!--                        <a href="#"><span class="_count">2514</span><span class="_img">-->
<!--                        <img src="/images/cat-other.png" alt="">-->
<!--                        <img src="/images/cat-other-hov.png" alt="">-->
<!--                        </span>-->
<!--                        <span class="_title"><span class="_title-inner">Others</span></span></a>-->
<!--                    </div>-->
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row row-list-news">
            <?= \frontend\widgets\Articles\LastArticles::widget() ?>
        </div>
        <?php if($last_adverts): ?>
        <div class="row list-products-home">
            <div class="list-products-slider-wrap">
                <div class="list-products-slider">
                <?php foreach($last_adverts as $item): ?>
                    <div class="item-product">
                        <div class="item-product-inner">
                            <header>
                                <div class="h3 title"><a href="<?= Url::to(['advert/view', 'id'=>$item->id]) ?>">Redcat Rampage ber...</a></div>
                                <div class="title-cat"><a href="#"><?= $item->title ?></a></div>
                            </header>
                            <figure><img src="/images/img-2.png" alt=""></figure>
                            <div class="price"><?= $item->price ?> <span class="cur-lbl">USD</span></div>
                            <div class="item-product-excerpt"><?= \yii\helpers\BaseStringHelper::truncateWords($item->body, 5, '...') ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="list-products-slider-arrows text-center"></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>





