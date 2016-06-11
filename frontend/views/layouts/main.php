<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\modules\cart\widgets\CartBlockWidget as CartBlock;
use frontend\modules\catalog\widgets\CatalogMenu\CatalogMenuWidget as CatalogMenu;
use frontend\widgets\SearchForm\SearchFormWidget as SearchForm;

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
    
    <header class="header">
        <div class="container-fluid"></div>
    </header>
    
    <?php
        echo CatalogMenu::widget(['vocabularyId' => 7]);
    ?>
    
<div class="wrap">
    <div class="container-fluid">
        <div class="control row">
            <div class="col-lg-5"><?=SearchForm::widget();?></div>
            <div class="col-lg-2"></div>
            <div class="col-lg-5 ">
                <?=CartBlock::widget();?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

       
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
