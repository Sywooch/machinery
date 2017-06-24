<?php
use yii\helpers\Html;

?>
<footer id="footer" class="site-footer">


    <div class="container">
        <div class="row">

            <div class="col-md-3">

                <a href="/" class="footer-logo">
                    <img src="/images/logo-foot.png" alt="footer-logo">
                </a>

                <div class="main-footer-menu">
                    <ul id="menu-footer" class="list-inline pull-left">
                        <li><a href="#"><?= Yii::t('For sellers') ?></a></li>
                        <li><a href="#"><?= Yii::t('How it works? ') ?></a></li>
                        <li><a href="#"><?= Yii::t('') ?></a></li>
                        <li><a href="#"><?= Yii::t('') ?></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <ul class="socialicons list-inline pull-right">
                    <li><a href="##" class="rss" rel="nofollow" target="_blank">
                            <i class="fa fa-rss"></i>
                        </a></li>
                    <li><a href="##" class="linkedin" rel="nofollow" target="_blank">
                            <i class="fa fa-linkedin"></i>
                        </a></li>
                    <li><a href="##" class="facebook" rel="nofollow" target="_blank">
                            <i class="fa fa-twitter"></i>
                        </a></li>
                    <li><a href="##" class="youtube" rel="nofollow" target="_blank">
                            <i class="fa fa-youtube"></i>
                        </a></li>
                    <li><a href="##" class="twitter" rel="nofollow" target="_blank">
                            <i class="fa fa-facebook"></i>
                        </a></li>
                </ul>
            </div>
            <div class="col-md-3 newsletter">
                <div class="newsletter-wrapper">
                	<h3 class="newsletter-title">Newsletter</h3>
                    <div>
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


            <div class="col footer-buttons">
                <div class="footer-buttons-wrapper">
                    <a data-toggle="modal" data-target="#myModalFeedback" class="ask-b footer-button" href="#">ask any
                        questions</a>
                    <a class="advent-b footer-button" href="/?page_id=139">add advent</a>
                </div>
                <div class=" main-footer--language">
                    <div
                        class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown"
                        id="lang_sel">
                        <ul>

                            <li tabindex="0"
                                class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-ru wpml-ls-current-language wpml-ls-last-item wpml-ls-item-legacy-dropdown">
                                <a href="#" class="wpml-ls-item-toggle lang_sel_sel icl-ru"><img
                                        class="wpml-ls-flag iclflag"
                                        src="http://port-test.pp.ua/wp-content/plugins/sitepress-multilingual-cms/res/flags/ru.png"
                                        alt="ru" title="Русский"><span class="wpml-ls-native icl_lang_sel_native">Русский</span></a>

                                <ul class="wpml-ls-sub-menu">

                                    <li class="icl-en wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-en wpml-ls-first-item">
                                        <a href="http://port-test.pp.ua?lang=en"><img class="wpml-ls-flag iclflag"
                                                                                      src="http://port-test.pp.ua/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                                                                                      alt="en" title="English"><span
                                                class="wpml-ls-native icl_lang_sel_native">English</span></a>
                                    </li>


                                    <li class="icl-de wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-de">
                                        <a href="http://port-test.pp.ua?lang=de"><img class="wpml-ls-flag iclflag"
                                                                                      src="http://port-test.pp.ua/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png"
                                                                                      alt="de" title="Deutsch"><span
                                                class="wpml-ls-native icl_lang_sel_native">Deutsch</span></a>
                                    </li>

                                </ul>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>


        </div>


    </div>


</footer>
