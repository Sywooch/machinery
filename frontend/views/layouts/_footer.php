<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>
<footer id="footer" class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-footer-logo">
                <a href="/" class="footer-logo">
                    <img src="/images/logo-foot.png" alt="footer-logo">
                </a>
                <div class="main-footer-menu">
                    <ul id="menu-footer" class="list-inline pull-left">
                        <li><?= \frontend\widgets\PageLink\PageLinkWidget::widget(['id'=>3]) ?></li>
                        <li><?= \frontend\widgets\PageLink\PageLinkWidget::widget(['id'=>1]) ?></li>
                        <li><?= \frontend\widgets\PageLink\PageLinkWidget::widget(['id'=>2]) ?></li>
                        <li><?= \frontend\widgets\PageLink\PageLinkWidget::widget(['id'=>4]) ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-footer-soc">
                <ul class="nav navbar-nav social-menu">
                    <li><a href="#"><i class="fa fa-vk" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="col-md-3 newsletter-footer-form">
                <div class="newsletter-footer-form-wrapper">
                    <?= \common\modules\subscribe\widgets\Subscribe\SubscribeFormWidget::widget() ?>

                </div>
            </div>

            <div class="col-md-3 footer-buttons">
                <div class="footer-buttons-wrapper">
                    <a data-toggle="modal" data-target="#myModalFeedback" class="ask-b footer-button" href="#">ask any
                        questions</a>
                    <a class="advert-b footer-button" href="<?= \yii\helpers\Url::to(['advert/create']) ?>"><?= Yii::t('app', 'add advent') ?></a>
                </div>
                <div class="dropup main-footer-language">
                    <ul class="menu-lang">
                        <li class="dropdown">
                            <?= \frontend\widgets\Language\LanguageSwitcher::widget() ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</footer>
<?php Modal::begin([
    'id' => 'status-modal',
    'header' => '<div class="text-header-modal">Header modal</div>',
    'bodyOptions' => ['class' => 'modal-body']
]); ?>
    <div class="text-status"></div>
<?php Modal::end(); ?>