<?php

use yii\helpers\Html;
use common\modules\file\helpers\StyleHelper;


$this->title = $model->translate->title;
$this->params['breadcrumbs'][] = [
    'label'=> Yii::t('app', 'Catalog'),
    'url' => 'catalog'
];
$this->params['breadcrumbs'][] = $model->translate->title;
?>
<?php
$this->beginBlock('title_panel');
echo Yii::t('app', 'Preview advert');
$this->endBlock();
?>

<!--<pre>--><?php //print_r($model) ?><!--</pre>-->
<div class="container main-container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-inner">
            <?php echo $this->render('/parts/left-sidebar') ?>

        </div>
        <div class="col-md-9">
            <div class="obj-container">
                <?php if($model->isAuthor($model) || Yii::$app->user->can('administrator')): ?>
                <div class="buttons-line">
                    <p class="advert-status status-not-publish text-danger">This listing is awaiting payment and is NOT live.</p>
                    <a href="<?= \yii\helpers\Url::to(['advert/delete/', 'id'=>$model->id]) ?>" data-confirm="<?= Yii::t('app', 'Delete?') ?>" class="btn btn-danger"><?= Yii::t('app','Delete') ?></a>
                    <a href="<?= \yii\helpers\Url::to(['advert/update/', 'id'=>$model->id]) ?>" class="btn btn-primary"><?= Yii::t('app','Edit') ?></a>
                    <?php if($model->isAuthor($model) && $model->order_options): ?>
                    <a href="#" class="btn btn-warning"><?= Yii::t('app','Make payment') ?></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="view-offer">
                    <h2 class="title-advert text-uppercase"><?= $model->translate->title ?></h2>
                    <?php if($model->phone): ?>
                    <div class="contact-advert-row"><i class="glyphicon glyphicon-phone"></i> <?= $model->phone ?></div>
                    <?php endif; ?>
                    <div class="advert-links-row">
                        <?php if($model->website): ?>
                        <a href="<?= $model->website ?>" target="_blank" class="btn btn-primary"><i class="ic-earth"></i><?= Yii::t('app', 'Visit website') ?></a>
                        <?php endif; ?>
                        <a href="#" class="btn btn-primary add-favorite"><i class="fa fa-heart" aria-hidden="true"></i> <?= Yii::t('app', 'Add favorites') ?></a>
                        <?php if($model->user_id != Yii::$app->user->id): ?>
                        <a href="#" class="btn btn-primary" data-toggle="modal"
                           data-target="#communityModal">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <?= Yii::t('app', 'Contact Author') ?>
                        </a>
                        <?php endif; ?>
                    </div>
<!--                    --><?php //dd($model->photos) ?>
                    <div class="object-images-row">
                        <div class="big-images">
                            <div class="big-images-slider gallery-swipe" itemscope itemtype="http://schema.org/ImageGallery">
                            <?php foreach($model->photos as $photo): ?>
                                <figure class="_item-slide" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                                    <a href="<?= $photo->path . '/' . $photo->name ?>" data-size="<?= $photo->width ?>x<?= $photo->height ?>" itemprop="contentUrl">
                                        <img src="<?= StyleHelper::getPreviewUrl($photo, '1600x900') ?>" alt="" itemprop="thumbnail" height="410">
                                        <i class="blur-bg" style="background-image: url(<?= StyleHelper::getPreviewUrl($photo, '1600x900') ?>)"></i>
                                    </a>
                                </figure>
                                <?php endforeach; ?>
                            </div>
                        </div> <!-- .big-images -->
                        <div class="small-images">
                            <div class="slider-nav">
                                <?php foreach($model->photos as $photo): ?>
                                <div class="slide-item">
                                <figure class="nav-inner-img">
                                <img src="<?= StyleHelper::getPreviewUrl($photo, '230x100') ?>" alt="" itemprop="thumbnail">
                                <i class="blur-bg" style="background-image: url(<?= StyleHelper::getPreviewUrl($photo, '230x100') ?>)"></i></figure></div>
                            <?php endforeach; ?>
                            </div>
                            <div class="count-string"><span id="slide-number">1</span> из <?= count($model->photos) ?> фото</div>
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
                                        <?php //dd($model->order_options);
                                        if($model->getOption($model, 4)): ?>
                                        <li><span><i class="fa fa-eye" aria-hidden="true"></i> <?= count($model->viewed) ?> <?= Yii::t('app', 'Views') ?></span></li>
                                        <?php endif; ?>
                                        <li><span><i class="fa fa-comments-o" aria-hidden="true"></i> <?= count($model->comments) ?> <?= Yii::t('app', 'Comments') ?></span></li>
                                        <li><a href="<?= \yii\helpers\Url::to(['advert/print', 'id'=>$model->id]) ?>"><i class="fa fa-print" aria-hidden="true"></i><?= Yii::t('app', 'Print this page') ?></a></li>
                                        <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i><?= Yii::t('app', 'Add Favorites') ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> <!-- .toolbox -->
                        <div class="data-specification col-md-8">
                            <div class="title-block h2 text-uppercase hidden-md hidden-lg"><?= Yii::t('app', 'specifications') ?>:</div>
                            <div class="data-content">
                                <table class="table table-striped specification-tbl">
                                    <?php if($model->manufacture): ?>
                                    <tr>
                                        <th><?= Yii::t('app', 'Manufacturer') ?></th>
                                        <td><?= $model->manufacture ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($model->model): ?>
                                    <tr>
                                        <th><?= Yii::t('app', 'Model') ?></th>
                                        <td><?= $model->model ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($model->year): ?>
                                    <tr>
                                        <th><?= Yii::t('app', 'Year of manufacture') ?></th>
                                        <td><?= $model->year ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($model->operating_hours): ?>
                                        <tr>
                                            <th><?= Yii::t('app', 'Operating Hours') ?></th>
                                            <td><?= $model->operating_hours ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if($model->mileage): ?>
                                        <tr>
                                            <th><?= Yii::t('app', 'Mileage') ?></th>
                                            <td><?= $model->mileage ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if($model->bucket_capacity): ?>
                                        <tr>
                                            <th><?= Yii::t('app', 'Bucket Capacity') ?></th>
                                            <td><?= $model->bucket_capacity ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if($model->tire_condition): ?>
                                        <tr>
                                            <th><?= Yii::t('app', 'Tire Condition') ?></th>
                                            <td><?= $model->tire_condition ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if($model->serial_number): ?>
                                        <tr>
                                            <th><?= Yii::t('app', 'Serial Number') ?></th>
                                            <td><?= $model->serial_number ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th><?= Yii::t('app', 'Condition') ?></th>
                                        <td><?= $model->condition ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="description-container col-md-12">
                            <?= $model->translate->body ?>



                            <?= \common\modules\comments\widgets\CommentsWidget::widget(['entity' => $model]); ?>


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
<?php //dd($model) ?>
<?= \common\modules\communion\widgets\CommunionFormWidget::widget(['subject'=>$model->translate->title, 'user_to' => $model->user_id]) ?>
