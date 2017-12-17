<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\helpers\CatalogHelper;

$cookies = Yii::$app->request->cookies;

$this->title = Yii::t('app', 'Production') . ' <span class="white">' . Yii::t('app', 'Catalog') . '</span> / ' . 'Industrial machinery';
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Catalog'),
    'url' => 'catalog'
];
$this->params['breadcrumbs'][] = 'Industrial machinery';
?>
<?php
$this->beginBlock('title_panel');
echo Yii::t('app', 'Production') . ' <span class="white">' . Yii::t('app', 'Catalog') . '</span> / ' . 'Industrial machinery';
$this->endBlock();
?>

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
            <div class="catalog-container">
                <div class="order-line flexbox just-between">
                    <div class="order-links">
                        <?= $sort->link('title') ?>
                        <?= $sort->link('date') ?>
                    </div>
                    <div class="view-links">
                        <a href="#"
                           class="btn-view btn-view-list <?= ((isset($_COOKIE['view']) && $_COOKIE['view'] == '_list') || !isset($_COOKIE['view'])) ? 'active' : '' ?>"
                           data-view="_list">list</a>
                        <a href="#"
                           class="btn-view btn-view-grid <?= isset($_COOKIE['view']) && $_COOKIE['view'] == '_grid' ? 'active' : '' ?>"
                           data-view="_grid">grid</a>
                    </div>
                </div>
                <!--                --><?php //print_r($_COOKIE);
                //                echo $cookies->getValue('view', 'mmm');
                ?>
                <div class="subcats-block">
                    <ul class="subcat-list flexbox flex-wrap ">

                        <?php foreach ($categories as $category): ?>
                            <?php if ($category->pid && $category->vid == 2): ?>
                                <li><a href="/<?=CatalogHelper::getRootCategory($categories, $category)->transliteration?>/<?= $category->transliteration ?>"><?= $category->name ?> (<?= $categoryCounts[$category->id]['c'] ?>)</a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if ($dataProvider): ?>

                    <div class="list-offers  <?= isset($_COOKIE['view']) ? '' . $_COOKIE['view'] : '_list' ?> flexbox cf">

                        <?php foreach ($dataProvider->models as $entity): ?>
                            <?php echo $this->render('/parts/item-offer', ['entity' => $entity]); ?>
                        <?php endforeach; ?>


                    </div> <!-- .list-favorite-adv -->
                    <nav class="pager-nav cf">

                        <?= LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                            'options' => ['class' => 'pagination ul-pager'],
                        ]); ?>

                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
