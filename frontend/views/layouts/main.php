<?php

use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\IEAsset;
use common\widgets\Alert;

use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;

use common\widgets\Filter\FilterWidget;

AppAsset::register($this);
IEAsset::register($this);
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

<body class="body-<?= Yii::$app->controller->id ?> body-<?= Yii::$app->controller->id . '-' . Yii::$app->controller->action->id ?>">
<?php $this->beginBody() ?>

<div class="wrap">

<?= $this->render('_header') ?>

<?php if(isset($this->params['breadcrumbs'])): ?>

    <div class="head-panel">
        <div class="container">
            <h1 class="title h1"><?= (isset($this->blocks['title_panel'])) ? $this->blocks['title_panel'] : $this->title  ?></h1>
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'tag' => 'div',
                'encodeLabels' => false,
                'options' => ['id' => 'breadcrumb'],
                'homeLink' => ['label' => '<i class="fa fa-home" aria-hidden="true"></i>', 'url' => ['/']],
                'itemTemplate' => '{link}  <i> / </i>',
                'activeItemTemplate' => '{link}'
            ])
            ?>
        </div>
    </div>
    <div class="filter-drop-wrap">
        <div class="filter-drop-container">
            <div class="container">
                <button class="btn-close close-drop">x</button>
                <?= FilterWidget::widget(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
        <?= Alert::widget() ?>
        <?= $content ?>

</div> <!-- .wrap -->

<?= $this->render('_footer') ?>

<?= Modal::widget([
    'id' => 'modalShow',
    'header' => '<span></span>',
]); ?>
<script>
    window.userId = <?=Yii::$app->user->id ? Yii::$app->user->id : 0;?>;
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
