<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'My favorite');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3   sidebar sidebar-account">
            <?= $this->render('_photo', ['profile' => $profile]) ?>
            <?= $this->render('_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">
                <?= $this->render('_head') ?>

                <div class="list-offers _list flexbox cf">
                    <?php for($i=0; $i<3; $i++): ?>
                    <div class="offer-item flexbox">
<!--                        <div class="_content _right">-->
                            <header class="head-offer">
                                <div class="col-md-12">
                                    <h3 class="h3"><a href="">Lorem ipsum dolor sit amet.</a></h3>
                                    <div class="_category-link"><a href="#">Вилочные погрузчики</a></div>
                                </div>
                            </header>
                            <figure class="img-offer"><img src="/images/img-2.png" alt=""></figure>
                            <div class="cf row-inner-offer _middle-inner">
                                <div class="col-md-6"><i class="glyphicon glyphicon-phone"></i> +38 050 555 55 22, +38 022 444 66 88</div>
                                <div class="col-md-6"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> mail@mail.com</div>
                            </div>
                            <div class="cf row-inner-offer _bottom-inner">
                                <div class="col-md-6">
                                    <div class="price">255 <span class="cur-lbl">USD</span></div>
                                    <div class="_descr"><?php echo common\helpers\BfrStr::substr('Lorem ipsum dolor sit amet, consectetur adipisicing elit', 50) ?></div>
                                </div>
                                <div class="col-md-6">
                                    <?= Html::a(Yii::t('app', 'Read more'), '#', ['class'=>'btn btn-warning']) ?>
                                </div>
                            </div>
<!--                        </div>-->
                    </div> <!-- .favorite-item -->
                    <?php endfor; ?>

                </div> <!-- .list-favorite-adv -->

            </div>
        </div>
    </div>
</div>