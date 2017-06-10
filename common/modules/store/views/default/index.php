<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use common\modules\store\CartAsset;
use yii\widgets\Breadcrumbs;
use common\modules\store\widgets\Filter\FilterWidget;

CartAsset::register($this);

$this->title = Html::encode($current->name);
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => '/catalog'];
$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => '/' . $parent->transliteration];
$this->params['breadcrumbs'][] = $this->title;

$products = $dataProvider->getModels();

?>


<div class="container catalog-list ">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <div class="row ">
        <div class="col-lg-3">
            <noindex>
                <?= FilterWidget::widget(['finder' => $finder, 'url' => $url]); ?>
            </noindex>
        </div>
        <div class="col-lg-9">
            <h1><?= Html::encode($current->name); ?></h1>
            <div class="items-counter">Найдено: <?= $dataProvider->pagination->totalCount; ?></div>
            <div class="sort">
                <span>Сортировка:</span>
                <?=$sort->link('price-asc') ?>
                <?=$sort->link('price-desc') ?>
            </div>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <?= $this->render('_itemA', [
                        'product' => $product,
                    ]); ?>
                <?php endforeach; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'nextPageLabel' => false,
                'prevPageLabel' => false,
                // 'maxButtonCount' => 4,
            ]); ?>
        </div>

    </div>

</div>


