<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\widgets\UserBlock\UserBlock;
use backend\widgets\AdminMenu\MainMenu;
use backend\widgets\AdminMenu\TopMenu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php
    $bodyClass = '';
    if (isset(Yii::$app->controller->id))
        $bodyClass .= Yii::$app->controller->id;
    if (isset(Yii::$app->controller->action->actionMethod))
        $bodyClass .= ' ' . Yii::$app->controller->action->actionMethod;
?>
<body class="<?= $bodyClass; ?>  hold-transition skin-blue fixed sidebar-mini">

        <?php $this->beginBody() ?>
        <div class="wrap">

            <?php if (Yii::$app->user->isGuest): ?>

                <div class="container">
                    <?= $content ?>
                </div>

            <?php else: ?>
            <header class="main-header">
                <!-- Logo -->
                <a href="<?= yii\helpers\Url::to(['/']); ?>" class="logo">
                    <span class="logo-lg"><b>Admin</b>Panel</span>
                </a>
                <?= $this->render('top-menu') ?>
            </header>
            <aside class="main-sidebar">
                <?= $this->render('sidebar') ?>
            </aside>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <?php if (isset($this->params['breadcrumbs'])): ?>
                        <?=
                        Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'tag' => 'ol',
                            'encodeLabels' => false,
                            'options' => ['id' => 'breadcrumb', 'class' => 'breadcrumb'],
                            'homeLink' => ['label' => '<li><i class="fa fa-dashboard" aria-hidden="true"></i> Home</li>', 'url' => ['/']],
                            'itemTemplate' => '<li>{link}</li>',
                            'activeItemTemplate' => '<li class="active">{link}</li>'
                        ])
                        ?>
                    <?php endif; ?>

                </section>
                <!-- Main content -->
                <section class="content">
                    <?= TopMenu::widget(); ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </section>
            </div>

        </div>
            <?php endif; ?>

        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
