<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
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
        echo CatalogMenu::widget(['vocabularyId' => Yii::$app->params['catalog']['vocabularyId']]);
    ?>
    
<div class="wrap">
    <div class="container-fluid">
        <div class="control row">
            <div class="col-lg-5"><?=SearchForm::widget();?></div>
            <div class="col-lg-2"></div>
            <div class="col-lg-5 ">
                
                <div class="login">
                    <?php if(Yii::$app->user->id):?>
                     <a href="/user/<?=Yii::$app->user->id;?>">Профиль</a>
                    |
                    <a href="/user/logout" data-method="post">Выход</a>
                    <?php else:?>
                     <a href="/login">Войти</a>
                    |
                    <a href="/user/register" >Регистрация</a>
                    <?php endif;?>
                </div>
                <?=CartBlock::widget();?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
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
