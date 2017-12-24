<?php
use yii\helpers\Html;

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
                	<h3 class="newsletter-title">Newsletter</h3>
                    <div class="newsletter-form">
                        <form class="">
                            <div class="form-group required">
								<input type="text" id="" class="form-control" name="" tabindex="1" placeholder="Enter your mail" aria-required="true">
								<div class="help-block"></div>
							</div>
							<div class="form-group"><button type="submit">Subscribe</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3 footer-buttons">
                <div class="footer-buttons-wrapper">
                    <a data-toggle="modal" data-target="#myModalFeedback" class="ask-b footer-button" href="#">ask any
                        questions</a>
                    <a class="advert-b footer-button" href="<?= \yii\helpers\Url::to(['advert/create']) ?>"><?= Yii::t('app', 'add advent') ?></a>
                </div>
                <div class="dropup main-footer-language">
                    <ul class="menu-lang mmmm">
                        <li class="dropdown">
                            <?= \frontend\widgets\Language\LanguageSwitcher::widget() ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</footer>