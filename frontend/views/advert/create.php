<?php

use yii\helpers\Html;

$cookies = Yii::$app->request->cookies;

$this->title = Yii::t('app', 'Production') . ' <span class="white">' . Yii::t('app', 'Catalog') . '</span> / ' . 'Industrial machinery';
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Catalog'),
    'url' => 'catalog'
];
$this->params['breadcrumbs'][] = 'Industrial machinery';
?>
<div class="container main-container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-inner">
            <div class="block-sidebar block-sidebar-packages block-sidebar-bg block-bg-texture">
                <div class="btn-filter-open-wrap">
                    <a href="#" type="button" class="open-filter btn-open-filter btn">
                    <i class="ic-arr-orange-button"></i></a>
                </div>
                <div class="h2 block-title"><?= Yii::t('app', 'Select your package:') ?></div>
                <div class="block-content">
                    <form>

                        <div class="list-packages">
                            <div class="package-item flexbox just-between">
                                <input type="radio" id="pack-1" name="package">
                                <label for="pack-1" class=" flexbox just-between dropdown">
                                    <span class="_price flexbox"><span class="align-auto">10$</span></span>
                                    <span class="_title-block">
                                    <span class="_title">Starter</span>
                                    <span class="_subtitle">Special offer!</span>
                                </span>
                                </label>
                                <div class="info-block btn-hover-hint">
                                    <div class="info-btn-bg">
                                        <div class="info-btn"><i class="fa fa-info" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="package-description-block package-drop">
                                        <form>
                                            <div class="info-inner">
                                                <div class="h2">Starter Parkage </div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit quia aspernatur optio recusandae, atque, reiciendis tempore doloremque temporibus aliquid nemo vitae sint? Aliquid ab, eaque blanditiis hic sint odit! Voluptas.</p>
                                                <div class="h3">$20 for a 30 day listing.</div>
                                                <ul class="list-options-package">
                                                    <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Featured Listing</span></li>
                                                    <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>HTML Listing Content</span></li>
                                                    <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Visitor Counter</span></li>
                                                    <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Top of Category</span></li>
                                                    <li class="disabled"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Google Map</span></li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- .package-item -->
                            <div class="package-item flexbox just-between dropdown">
                                <input type="radio" id="pack-2" name="package">
                                <label for="pack-2" class=" flexbox just-between dropdown">
                                    <span class="_price flexbox"><span class="align-auto">30$</span></span>
                                    <span class="_title-block">
                                    <span class="_title">Professional</span>
                                    <span class="_subtitle">Special offer!</span>
                                </span>
                                </label>
                                <div class="info-block btn-hover-hint"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="info-btn-bg">
                                        <div class="info-btn"><i class="fa fa-info" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="package-description-block package-drop">
                                        <div class="info-inner">
                                            <div class="h2">Professional Parkage </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit quia aspernatur optio recusandae, atque, reiciendis tempore doloremque temporibus aliquid nemo vitae sint? Aliquid ab, eaque blanditiis hic sint odit! Voluptas.</p>
                                            <div class="h3">$20 for a 30 day listing.</div>
                                            <ul class="list-options-package">
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Featured Listing</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>HTML Listing Content</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Visitor Counter</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Top of Category</span></li>
                                                <li class="disabled"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Google Map</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .package-item -->
                            <div class="package-item flexbox just-between dropdown">
                                <input type="radio" id="pack-3" name="package">
                                <label for="pack-3" class=" flexbox just-between dropdown">
                                    <span class="_price flexbox"><span class="align-auto">50$</span></span>
                                    <span class="_title-block">
                                    <span class="_title">Corporate</span>
                                    <span class="_subtitle">Special offer!</span>
                                </span>
                                </label>
                                <div class="info-block btn-hover-hint" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="info-btn-bg">
                                        <div class="info-btn"><i class="fa fa-info" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="package-description-block package-drop">
                                        <div class="info-inner">
                                            <div class="h2">Corporate Parkage </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit quia aspernatur optio recusandae, atque, reiciendis tempore doloremque temporibus aliquid nemo vitae sint? Aliquid ab, eaque blanditiis hic sint odit! Voluptas.</p>
                                            <div class="h3">$20 for a 30 day listing.</div>
                                            <ul class="list-options-package">
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Featured Listing</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>HTML Listing Content</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Visitor Counter</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Top of Category</span></li>
                                                <li class="disabled"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Google Map</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .package-item -->
                            <div class="package-item flexbox just-between dropdown">
                                <input type="radio" id="pack-4" name="package">
                                <label for="pack-4" class=" flexbox just-between dropdown">
                                    <span class="_price flexbox"><span class="align-auto">100$</span></span>
                                    <span class="_title-block">
                                    <span class="_title">Maximum</span>
                                    <span class="_subtitle">Special offer!</span>
                                </span>
                                </label>
                                <div class="info-block btn-hover-hint" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="info-btn-bg">
                                        <div class="info-btn"><i class="fa fa-info" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="package-description-block package-drop">
                                        <div class="info-inner">
                                            <div class="h2">Maximum Parkage </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit quia aspernatur optio recusandae, atque, reiciendis tempore doloremque temporibus aliquid nemo vitae sint? Aliquid ab, eaque blanditiis hic sint odit! Voluptas.</p>
                                            <div class="h3">$20 for a 30 day listing.</div>
                                            <ul class="list-options-package">
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Featured Listing</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>HTML Listing Content</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Visitor Counter</span></li>
                                                <li class="active"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Top of Category</span></li>
                                                <li class="disabled"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Google Map</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .package-item -->

                        </div>
                    </form>
                </div>
            </div>
            <div class="block-sidebar block-ads">
                <div class="item-ads"><a href="#"> <img src="/images/b2.png" alt=""></a></div>
                <div class="item-ads"><a href="#"> <img src="/images/b4.png" alt=""></a></div>
            </div>
            <div class="block-sidebar block-list-enhancements block-bg-color block-sidebar-bg">
                <div class="h2 title-block grey-ttl  text-uppercase"><?= Yii::t('app', 'Listing Enhancements:') ?></div>
                <div class="block-content">
                    <div class="_text">Enhance your listing with any of the additional features below;</div>
                    <div class="list-enhancements">
                        <div class="item-enhancement">
                            <div class="inner-item-enhancement flexbox">
                                <input type="checkbox" name="enhancement[1]" id="enhancement-1">
                                <label class="label" for="enhancement-1">
                                    <span class="_price">$ 15</span>
                                    <span class="span _name">Featured Listing</span>
                                </label>
                                <div class="info-block btn-hover-hint">
                                    <div class="info-btn-bg ">
                                        <div class="info-btn"><i class="fa fa-info" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="package-description-block package-drop">
                                        <div class="info-inner">
                                            <div class="h2">Maximum Parkage </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit quia aspernatur optio recusandae, atque, reiciendis tempore doloremque temporibus aliquid nemo vitae sint? Aliquid ab, eaque blanditiis hic sint odit! Voluptas.</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item-enhancement">
                            <div class="inner-item-enhancement flexbox">
                                <input type="checkbox" name="enhancement[2]" id="enhancement-2">
                                <label class="label" for="enhancement-2">
                                    <span class="_price">$ 15</span>
                                    <span class="span _name">Featured Listing</span>
                                </label>
                                <span class="btn-hint"><i class="ic-i"></i></span>
                                <div class="_hint-block"></div>
                            </div>
                        </div>
                        <div class="item-enhancement">
                            <div class="inner-item-enhancement flexbox">
                                <input type="checkbox" name="enhancement[3]" id="enhancement-3">
                                <label class="label" for="enhancement-3">
                                    <span class="_price">$ 15</span>
                                    <span class="span _name">Featured Listing</span>
                                </label>
                                <span class="btn-hint"><i class="ic-i"></i></span>
                                <div class="_hint-block"></div>
                            </div>
                        </div>
                        <div class="item-enhancement">
                            <div class="inner-item-enhancement flexbox">
                                <input type="checkbox" name="enhancement[4]" id="enhancement-4">
                                <label class="label" for="enhancement-">
                                    <span class="_price">$ 15</span>
                                    <span class="span _name">Featured Listing</span>
                                </label>
                                <span class="btn-hint"><i class="ic-i"></i></span>
                                <div class="_hint-block"></div>
                            </div>
                        </div>
                        <div class="item-enhancement">
                            <div class="inner-item-enhancement flexbox">
                                <input type="checkbox" name="enhancement[5]" id="enhancement-6">
                                <label class="label" for="enhancement-5">
                                    <span class="_price">$ 15</span>
                                    <span class="span _name">Featured Listing</span>
                                </label>
                                <span class="btn-hint"><i class="ic-i"></i></span>
                                <div class="_hint-block"></div>
                            </div>
                        </div>
                        <div class="item-enhancement">
                            <div class="inner-item-enhancement flexbox">
                                <input type="checkbox" name="enhancement[6]" id="enhancement-6">
                                <label class="label" for="enhancement-6">
                                    <span class="_price">$ 15</span>
                                    <span class="span _name">Featured Listing</span>
                                </label>
                                <span class="btn-hint"><i class="ic-i"></i></span>
                                <div class="_hint-block"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-sidebar block-total-pay block-bg-color block-sidebar-bg">
                <div class="h2 title-block grey-ttl text-uppercase"><?= Yii::t('app', 'Total payment') ?></div>
                <div class="block-content text-center">
                    <div class="_text text-uppercase"><b>$20</b> for a <b>30</b> day listing;</div>
                    <a href="#" class="btn btn-warning btn-pay"><?= Yii::t('app', 'Pay') ?> <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="advert-container">
                <div class="form-wrapper">
                    <form action="#">
                        <div class="form-inner">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Краткое описание
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </a>

                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="form-row">
                                                <div class="form-group"><label for="">Title:</label>
                                                    <input type="text" name="" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group"><label for="">Description:</label>
                                                    <textarea  name="" id="" class="form-control"></textarea>
                                                </div>
                                                <div class="_hint-form">Minimum of 200 characters. 200 characters remaining.</div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group"><label for="">Keywords::</label>
                                                    <input type="text" name="" id="" class="form-control">
                                                </div>
                                                <div class="_hint-form">Separate each keyword with a comma.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <?= Yii::t('app', 'Listing Details') ?>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="">Website link: <span class="require">*</span></label>
                                                    <input type="text" name="" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="">Manufacturer</label>
                                                    <textarea  name="" id="" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="">Phone Number:</label>
                                                    <input type="text" name="" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="">Model:</label>
                                                    <input type="text" name="" id="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <?= Yii::t('app', 'Listing Attachments') ?>
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <div class="image-upload-block cf">
                                                <?php for($i=0;$i<5;$i++): ?>
                                                <figure class="img-offer" style="background-image: url(/images/img-2.png)">
                                    <!-- <img src="/images/img-2.png" alt="">-->
                                                    <a href="#" class="btn-remove-img"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                </figure>
                                                <?php endfor; ?>
                                                <div class="image-upload-btn flexbox"><i class="ic-add-image"></i><span><?= Yii::t('app', 'Add images') ?></span></div>
                                            </div>
                                            <p class="text-uppercase"><?= Yii::t('app', 'You can select up to 30 media files.') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-right">
                                <button type="submit" class="btn btn-warning"><?= Yii::t('app', 'Save listing') ?></button>
                                <button type="reset" class="btn btn-default"><?= Yii::t('app', 'Cancel') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>