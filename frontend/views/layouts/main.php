<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\modules\store\widgets\CartBlock\CartBlockWidget as CartBlock;
use common\modules\store\widgets\CatalogMenu\CatalogMenuWidget as CatalogMenu;
use frontend\widgets\SearchForm\SearchFormWidget as SearchForm;
use common\modules\store\widgets\Compare\CompareWidget;
use common\modules\store\widgets\Wish\WishWidget;
use yii\bootstrap\Modal;


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
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <div class="control row">
            <div class="col-lg-7"><?=SearchForm::widget();?></div>

            <div class="col-lg-5 menu-action-items">
                <?=$this->render('_login');?>
                <?=CartBlock::widget();?>
                <?=WishWidget::widget();?>
                <?=CompareWidget::widget();?>
            </div>
        </div>
    </div>
</div>

<?=CatalogMenu::widget(['vocabularyId' => Yii::$app->params['catalog']['vocabularyId']]);?>
    
<div class="wrap">
    <div class="container-fluid">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; Магазин <?= date('Y') ?></p>

       
    </div>
</footer>

    <?=Modal::widget([
            'id' => 'modalShow',
            'header' => '<span></span>',
        ]);?>
    <script>
        window.userId = <?=Yii::$app->user->id ? Yii::$app->user->id : 0;?>;
    </script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
