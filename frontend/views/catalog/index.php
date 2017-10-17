<?php

use yii\helpers\Html;

$cookies = Yii::$app->request->cookies;

$this->title = Yii::t('app', 'Production') . ' <span class="white">' . Yii::t('app', 'Catalog') . '</span> / ' . 'Industrial machinery';
$this->params['breadcrumbs'][] = [
    'label'=> Yii::t('app', 'Catalog'),
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
                        <a href="#" class="_asc"><?= Yii::t('app','Title') ?><i class="icon-order"></i></a>
                        <a href="#" class="_desc"><?= Yii::t('app','Date') ?><i class="icon-order"></i></a>
                        <a href="#"><?= Yii::t('app','Popularity') ?><i class="icon-order"></i></a>
                        <a href="#"><?= Yii::t('app','Featured') ?><i class="icon-order"></i></a>
                        <a href="#"><?= Yii::t('app','Rating') ?><i class="icon-order"></i></a>
                        <a href="#"><?= Yii::t('app','Nearest') ?><i class="icon-order"></i></a>
                    </div>
                    <div class="view-links">
                        <a href="#" class="btn-view btn-view-list <?= ((isset($_COOKIE['view']) && $_COOKIE['view']  == '_list' ) || !isset($_COOKIE['view']) ) ? 'active' : '' ?>" data-view="_list">list</a>
                        <a href="#" class="btn-view btn-view-grid <?= isset($_COOKIE['view']) && $_COOKIE['view'] == '_grid' ? 'active' : '' ?>" data-view="_grid">grid</a>
                    </div>
                </div>
<!--                --><?php //print_r($_COOKIE);
//                echo $cookies->getValue('view', 'mmm');
                ?>
                <div class="subcats-block">
                    <ul class="subcat-list flexbox flex-wrap just-between">
                        <li><a href="#">Bending machines (21)</a></li>
                        <li><a href="#">Combined machines (3)</a></li>
                        <li><a href="#">Copying machines (1)</a></li>
                        <li><a href="#">Cutting (7)</a></li>
                        <li><a href="#">Dovetail jointing equipment (0)</a></li>
                        <li><a href="#">Dryers (3)</a></li>
                        <li><a href="#">Forging equipment (3)</a></li>
                        <li><a href="#">Lathes (7)</a></li>
                        <li><a href="#">Milling machines (24)</a></li>
                        <li><a href="#">Moulding machines (1)</a></li>
                        <li><a href="#">Painting machines (3)</a></li>
                        <li><a href="#">Planing machines (15)</a></li>
                        <li><a href="#">Printing machines (13)</a></li>
                        <li><a href="#">Saw mills (4)</a></li>
                        <li><a href="#">Shears (17)</a></li>
                        <li><a href="#">Sizing (8)</a></li>
                        <li><a href="#">Thread processing machines (1)</a></li>
                        <li><a href="#">Welding / cutting (9)</a></li>
                        <li><a href="#">Work benches (2)</a></li>
                        <li><a href="#">All (2442)</a></li>
                    </ul>
                </div>
                <div class="list-offers  <?= isset($_COOKIE['view']) ? ''.$_COOKIE['view'] : '_list' ?> flexbox cf">
                    <?php for($i=0; $i<12; $i++): ?>
                        <?php echo $this->render('/parts/item-offer'); ?>
                    <?php endfor; ?>

                </div> <!-- .list-favorite-adv -->
                <nav>
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
