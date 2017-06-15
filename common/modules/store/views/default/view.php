<?php
use yii\helpers\Html;
use common\modules\store\CartAsset;
use common\modules\store\helpers\CartHelper;
use common\modules\store\helpers\ProductHelper;
use common\modules\store\helpers\CatalogHelper;
use kartik\rating\StarRating;
use yii\widgets\Breadcrumbs;


CartAsset::register($this);

$map = [
    'otzyvy' => 'Отзывы'
];


$this->title = isset($tab) ? $entity->title . ' ' . $map[$tab] : ProductHelper::titlePattern($entity);
$this->params['breadcrumbs'] = ProductHelper::getBreadcrumb($entity);
?>

<div class="product container">
    <div class="clearfix">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <span class="sku">Код: <?= Html::encode($entity->sku); ?></span>
        <?= StarRating::widget([
            'name' => 'rating_35',
            'value' => $entity->rating,
            'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
        ]);
        ?>
        <a class="print-wrapper" onclick="window.print();"><i class="fa fa-print" aria-hidden="true"></i>Распечатать</a>
    </div>




    <h1><?= Html::encode($this->title); ?></h1>
    <div class="btn-group custom" role="group" aria-label="...">
        <a type="button" class="btn btn-default" href="/<?= $entity->url->alias ?>">Характеристики</a>
        <a type="button" class="btn btn-default" href="/<?= $entity->groupAlias->alias ?>/otzyvy">Отзывы</a>
    </div>

    <?php if (isset($tab)): ?>
        <?= $this->render('_' . $tab, [
            'entity' => $entity,
            'products' => $entitys
        ]); ?>
    <?php else: ?>
        <?= $this->render('_main', [
            'entity' => $entity,
        ]); ?>
    <?php endif; ?>

</div>
