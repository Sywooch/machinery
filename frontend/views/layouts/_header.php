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
                    <li><?= \common\helpers\PageLink::a(3) ?></li>
                    <li><?= \common\helpers\PageLink::a(1) ?></li>
                    <li><?= \common\helpers\PageLink::a(2) ?></li>
                    <li><?= \common\helpers\PageLink::a(4) ?></li>
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
                                <li><?= Html::a('<i class="fa fa-list" aria-hidden="true"></i> ' . Yii::t('app', 'My Listings'), ['/advert/listing']) ?></li>
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
                    <?= \frontend\widgets\SearchForm\SearchFormWidget::widget() ?>
                </div>

            </div>
        </div>
    </div>
</header>
