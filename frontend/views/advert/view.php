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
                    <p class="advert-status status-not-publish text-danger">This listing is awaiting payment and is NOT live.</p>
                    <a href="#" class="btn btn-danger"><?= Yii::t('app','Delete') ?></a>
                    <a href="#" class="btn btn-primary"><?= Yii::t('app','Edit') ?></a>
                    <a href="#" class="btn btn-warning"><?= Yii::t('app','Make payment') ?></a>
                </div>
                <div class="view-offer">
                    <h2 class="title-advert text-uppercase">Redcat Rampage berrgsrg в широком пишется все название</h2>
                    <div class="contact-advert-row"><i class="glyphicon glyphicon-phone"></i> 123-456-789;  123-456-789;</div>
                    <div class="advert-links-row">
                        <a href="#" class="btn btn-primary"><i class="ic-earth"></i><?= Yii::t('app', 'Visit website') ?></a>
                        <a href="#" class="btn btn-primary add-favorite"><i class="fa fa-heart" aria-hidden="true"></i> <?= Yii::t('app', 'Add favorites') ?></a>
                        <a href="#" class="btn btn-primary"><i class="fa fa-envelope" aria-hidden="true"></i> <?= Yii::t('app', 'Contact Author') ?></a>
                    </div>
                    <div class="advert-images-row">
                        <div class="big-images">
                            <div class="big-images-slider gallery-swipe" itemscope itemtype="http://schema.org/ImageGallery">
                            <?php for($i=0; $i<7; $i++): ?>
                                <figure class="_item-slide" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="/images/img-big-advert.png" data-size="1600x900" itemprop="contentUrl">
                                        <img src="/images/img-big-advert.png" alt="" itemprop="thumbnail">
                                        <i class="blur-bg" style="background-image: url(/images/img-big-advert.png)"></i>
                                    </a>
                                </figure>
                                <?php endfor; ?>
                            </div>
                        </div> <!-- .big-images -->
                        <div class="small-images">
                            <div class="slider-nav">
                            <?php for($i=0; $i<7; $i++): ?>
                                <div class="slide-item">
                                <figure class="nav-inner-img">
                                <img src="/images/img-big-advert.png" alt="" itemprop="thumbnail">
                                <i class="blur-bg" style="background-image: url(/images/img-big-advert.png)"></i></figure></div>
                            <?php endfor; ?>
                            </div>
                            <div class="count-string"><span id="slide-number">1</span> из 14 фото</div>
                        </div> <!-- .small-images -->
                    </div> <!-- .advert-images-row -->
                    <div class="container-links row">
                        <div class="link-part text-uppercase col-md-4"><a href="#" class="active nav-parts-adv"><?= Yii::t('app', 'Description') ?></a></div>
                        <div class="link-part text-uppercase col-md-4"><a href="#" class="nav-parts-adv"><?= Yii::t('app', 'Comments') ?></a></div>
                        <!-- <div class="links-parts">
                        </div> <!-- .links-parts -->
                        <div class="block toolbox col-md-4 pull-right">
                            <div class="inner-bg">
                                <header class="head-toolbox h2 text-uppercase"><?= Yii::t('app', 'TOOLBOX') ?></header>
                                <div class="toolbox-content">
                                    <ul class="data-toolbox">
                                        <li><span><i class="fa fa-eye" aria-hidden="true"></i> 5 Views</span></li>
                                        <li><span><i class="fa fa-comments-o" aria-hidden="true"></i> 0 Comments</span></li>
                                        <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i>Print this page</a></li>
                                        <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Add Favorites</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> <!-- .toolbox -->
                        <div class="data-specification col-md-8">
                            <div class="title-block h2 text-uppercase hidden-md hidden-lg"><?= Yii::t('app', 'specifications') ?>:</div>
                            <div class="data-content">
                                <table class="table table-striped specification-tbl">
                                    <tr>
                                        <th><?= Yii::t('app', 'Manufacturer') ?></th>
                                        <td>Caterpillar</td>
                                    </tr>
                                    <tr>
                                        <th><?= Yii::t('app', 'Model') ?></th>
                                        <td>432E</td>
                                    </tr>
                                    <tr>
                                        <th><?= Yii::t('app', 'Year of manufacture') ?></th>
                                        <td>2008</td>
                                    </tr>
                                    <tr>
                                        <th><?= Yii::t('app', 'Condition') ?></th>
                                        <td>Used</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="description-container col-md-12">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium sit quam reprehenderit debitis, labore itaque voluptas, quidem deserunt asperiores possimus!</p>
                            <p>Exercitationem autem eaque, et voluptates facilis eveniet, voluptate harum debitis dolorem, sint similique molestias hic quos in? Eaque, aliquam architecto.</p>
                        </div> <!-- .description-container -->
                    </div> <!-- .container-links -->

                </div> <!-- .view-offer -->

            </div>
        </div>
    </div>
    <div class="row row-list-news">
        <?= \frontend\widgets\Articles\LastArticles::widget() ?>
    </div>
</div>

