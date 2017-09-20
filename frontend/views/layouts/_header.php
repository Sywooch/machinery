<?php
use yii\helpers\Html;

?>

<header class="site-header">
    <nav class="navbar navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#">For sellers </a></li>
                    <li><a href="#">about us</a></li>
                    <li><a href="#">How it works?</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">EUR <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">USD</a></li>
                            <li><a href="#">UAH</a></li>
                            <li><a href="#">RUB</a></li>
                        </ul>
                    </li>
                    <?php if (Yii::$app->user->isGuest): ?>

                        <li><?= Html::a('<i class="fa fa-key" aria-hidden="true"></i> ' . Yii::t('user', 'LOGIN'), ['/user/login'], ['class' => 'link-login']) ?></li>
                        <li><?= Html::a('<i class="fa fa-user-plus" aria-hidden="true"></i> ' . Yii::t('user', 'REGISTER'), ['/user/register'], ['class' => 'link-register']) ?></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <?= Html::a('<i class="fa fa-user" aria-hidden="true"></i> ' . Yii::t('user', 'Profile') . ' <span class="caret"></span>',
                                ['/user/profile'],
                                ['class' => 'link-profile dropdown-toggle', 'data-toggle' => "dropdown", 'role' => "button", 'aria-haspopup' => "true", 'aria-expanded' => "false"]) ?>
                            <ul class="dropdown-menu">
                                <li><?= Html::a('<i class="fa fa-cog" aria-hidden="true"></i> ' . Yii::t('user', 'View profile'), ['/user/profile']) ?></li>
                                <li><?= Html::a('<i class="fa fa-user" aria-hidden="true"></i> ' . Yii::t('user', 'My Account'), ['/user/settings/account']) ?></li>
                                <li><?= Html::a('<i class="fa fa-list" aria-hidden="true"></i> ' . Yii::t('app', 'My Listings'), ['/profile/published']) ?></li>
                                <li><?= Html::a('<i class="fa fa-heart" aria-hidden="true"></i> ' . Yii::t('app', 'My favorite'), ['/profile/favorite']) ?></li>
                                <li><?= Html::a('<i class="fa fa-sign-out" aria-hidden="true"></i> ' . Yii::t('app', 'Logout'), ['/user/logout'], ['data-method' => 'post']) ?></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="dropdown langs-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><img
                                    src="/images/langs/lang-de.png" alt="">CHANGE language <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><img src="/images/langs/lang-de.png" alt=""> DE</a></li>
                            <li><a href="#"><img src="/images/langs/lang-ru.png" alt=""> RU</a></li>
                            <li><a href="#"><img src="/images/langs/lang-en.png" alt=""> EN</a></li>
                        </ul>
                    </li>
                    <li role="presentation"><a href="#"><span class="badge">3</span></a></li
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
        <div class="row header-section flexbox just-between">
            <div class="col-md-4 header-logo-col"><a href="/" class="logo"><img src="/images/logo.png" alt=""></a></div>
            <div class="col-md-3 header-button-col">
                <a href="<?= \yii\helpers\Url::to(['/advert/create']) ?>" class="btn btn-warning link-top-add-adv"><?= Yii::t('app', 'Add advert') ?> *</a>
                <p><?= Yii::t('app', '* Two months of free and free ads') ?></p>
            </div>
            <div class="col-md-3 header-banner-col">
                <?= \frontend\widgets\AdsBanners\AdsBannersWidget::widget(['region'=>'header'])?>
            </div>
        </div>
        <div class="row row-search-form">
            <div class="col-md-12">
                <div class="block-search-form form-inline">
                    <form class="search-form">
                        <div class="search-form-inner flexbox just-between">
                            <div class="form-group search-type-group">
                                <select name="" id="" class="search-type form-control">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Veniam, voluptatibus?</option>
                                    <option value="">Commodi, ducimus.</option>
                                    <option value="">Quod, fugit.</option>
                                </select>
                            </div>
                            <div class="form-group search-text-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <div class="form-group search-submit-group">
                                <button type="submit" class="btn btn-warning "><i class="fa fa-search"
                                                                                  aria-hidden="true"></i>
                                    <span class="bn-search-inner"><b>Search,</b> or press</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="height: 16px">
                                        <path style="text-indent:0;text-align:start;line-height:normal;text-transform:none;block-progression:tb;-inkscape-font-specification:Sans; fill: #fff;"
                                              d="M 14 5 L 14 6 L 14 11 L 6 11 L 5 11 L 5 12 L 5 26 L 5 27 L 6 27 L 26 27 L 27 27 L 27 26 L 27 6 L 27 5 L 26 5 L 15 5 L 14 5 z M 16 7 L 25 7 L 25 25 L 7 25 L 7 13 L 15 13 L 16 13 L 16 12 L 16 7 z M 19 13 L 19 18 L 13.1875 18 L 14.96875 16.21875 L 13.53125 14.78125 L 10.03125 18.28125 L 9.34375 19 L 10.03125 19.71875 L 13.53125 23.21875 L 14.96875 21.78125 L 13.1875 20 L 20 20 L 21 20 L 21 19 L 21 13 L 19 13 z"
                                              overflow="visible" font-family="Sans"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</header>
