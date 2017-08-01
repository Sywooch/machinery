<?php

use yii\helpers\Html;


$this->title = 'Redcat Rampage berrgsrg в широком пишется все название';
$this->params['breadcrumbs'][] = [
    'label'=> Yii::t('app', 'Catalog'),
    'url' => 'catalog'
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Preview advert');
?>
<?php
$this->beginBlock('title_panel');
echo Yii::t('app', 'Preview advert');
$this->endBlock();
?>

<div class="container main-container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-inner">
            <?php echo $this->render('/parts/left-sidebar') ?>
            <div class="block-ads">
                <div class="item-ads"><a href="#"> <img src="/images/b2.png" alt=""></a></div>
                <div class="item-ads"><a href="#"> <img src="/images/b4.png" alt=""></a></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="advert-container">
                <div class="buttons-line">
                    <p class="advert-status status-not-publish">This listing is awaiting payment and is NOT live.</p>
                    <a href="#" class="btn btn-danger"><?= Yii::t('app','Delete') ?></a>
                    <a href="#" class="btn btn-primary"><?= Yii::t('app','Edit') ?></a>
                    <a href="#" class="btn btn-warning"><?= Yii::t('app','Make payment') ?></a>
                </div>
                <div class="view-offer">
                    <h2>Redcat Rampage berrgsrg в широком пишется все название</h2>
                    <div class="contact-advert-row"><i class="glyphicon glyphicon-phone"></i> 123-456-789;  123-456-789;</div>
                    <div class="advert-links-row">
                        <a href="#" class="btn btn-primary"><i class="ic-earth"></i><?= Yii::t('app', 'Visit website') ?></a>
                        <a href="#" class="btn btn-primary add-favorite"><i class="fa fa-heart" aria-hidden="true"></i> <?= Yii::t('app', 'Add favorites') ?></a>
                        <a href="#" class="btn btn-primary"><i class="fa fa-envelope" aria-hidden="true"></i> <?= Yii::t('app', 'Contact Author') ?></a>
                    </div>
                    <div class="advert-images-row">
                        <div class="big-images">
                            <div class="big-images-slider gallery-swipe" itemscope itemtype="http://schema.org/ImageGallery">
                                <figure class="_item-slide" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="/images/img-big-advert.png" data-size="1600x900" itemprop="contentUrl">
                                        <img src="/images/img-big-advert.png" alt="" itemprop="thumbnail">
                                        <i class="blur-bg" style="background-image: url(/images/img-big-advert.png)"></i>
                                    </a>
                                </figure>
                                <figure class="_item-slide" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="/images/img-big-advert.png" data-size="1600x900" itemprop="contentUrl">
                                        <img src="/images/img-big-advert.png" alt="" itemprop="thumbnail">
                                        <i class="blur-bg" style="background-image: url(/images/img-big-advert.png)"></i>
                                    </a>
                                </figure>
                                <figure class="_item-slide" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="/images/img-big-advert.png" data-size="1600x900" itemprop="contentUrl">
                                        <img src="/images/img-big-advert.png" alt="" itemprop="thumbnail">
                                        <i class="blur-bg" style="background-image: url(/images/img-big-advert.png)"></i>
                                    </a>
                                </figure>
                                <figure class="_item-slide" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="/images/img-big-advert.png" data-size="1600x900" itemprop="contentUrl">
                                        <img src="/images/img-big-advert.png" alt="" itemprop="thumbnail">
                                        <i class="blur-bg" style="background-image: url(/images/img-big-advert.png)"></i>
                                    </a>
                                </figure>
                                <figure class="_item-slide" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="/images/img-big-advert.png" data-size="1600x900" itemprop="contentUrl">
                                        <img src="/images/img-big-advert.png" alt="" itemprop="thumbnail">
                                        <i class="blur-bg" style="background-image: url(/images/img-big-advert.png)"></i>
                                    </a>
                                </figure>
                            </div>
                        </div>
                        <div class="small-images">
                            <div class="slider-nav">
                                <div class="slide-item"><img src="/images/img-big-advert.png" alt="" itemprop="thumbnail"></div>
                                <div class="slide-item"><img src="/images/img-big-advert.png" alt="" itemprop="thumbnail"></div>
                                <div class="slide-item"><img src="/images/img-big-advert.png" alt="" itemprop="thumbnail"></div>
                                <div class="slide-item"><img src="/images/img-big-advert.png" alt="" itemprop="thumbnail"></div>
                                <div class="slide-item"><img src="/images/img-big-advert.png" alt="" itemprop="thumbnail"></div>
                                <div class="slide-item"><img src="/images/img-big-advert.png" alt="" itemprop="thumbnail"></div>
                            </div>
                        </div>
                    </div>

                </div> <!-- .view-offer -->

            </div>
        </div>
    </div>
</div>

