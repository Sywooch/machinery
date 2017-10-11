<?php

use yii\helpers\Html;


$this->title = $model->title;

$this->params['breadcrumbs'][] = Yii::t('app', $model->title);
?>
<?php
$this->beginBlock('title_panel');
echo $model->title;
$this->endBlock();
?>
<!--<pre>--><?php //print_r($model) ?><!--</pre>-->
<div class="container main-container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-inner">
            <?php echo $this->render('/parts/left-sidebar') ?>
            <div class="block-ads">
                <div class="item-ads"><a href="#"> <img src="/images/b2.png" alt=""></a></div>
                <div class="item-ads"><a href="#"> <img src="/images/b4.png" alt=""></a></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="page-container">

                <div class="view-offer">
                    <h2 class="title-advert text-uppercase"><?= $model->title ?></h2>

                        <div class="description-container">
                            <?= $model->body ?>
                        </div> <!-- .description-container -->

                </div>

            </div>
        </div>
    </div>
    <div class="row row-list-news">
        <?= \frontend\widgets\Articles\LastArticles::widget() ?>
    </div>
</div>

