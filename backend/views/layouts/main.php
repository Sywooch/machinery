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
<body class="<?= $bodyClass; ?>">

        <?php $this->beginBody() ?>
        <div class="wrap">

            <?php if (Yii::$app->user->isGuest): ?>

                <div class="container">
                    <?= $content ?>
                </div>

            <?php else: ?>
                <div class="row">

                    <div class="col-md-2 col-lg-2 no-padding">
                         <?= UserBlock::widget(); ?>
                         <?=MainMenu::widget();?>
                    </div>

                    <div class="col-md-10 col-lg-10 no-padding">
                        <div class="widget-top-informers">
                            <div class="pull-left">
                                <?php
                                // echo Html::a('<span class="glyphicon glyphicon-edit pull-left"></span>',['/']);
                                ?>
                            </div>
                        </div>
                        

                        <div class="container-fluid ">
                            <div class="panel main-panel"><?=TopMenu::widget();?><?= $content ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
