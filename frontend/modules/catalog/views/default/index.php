<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;
use common\modules\file\helpers\StyleHelper;
use frontend\modules\catalog\helpers\CatalogHelper;
use frontend\modules\catalog\widgets\Filter\FilterWidget;

CartAsset::register($this);

$this->title = Html::encode($current->name);
$this->params['breadcrumbs'] = CatalogHelper::getBreadcrumb($current);

?>
<div class="row">
    <div class="col-lg-8">
        <?php foreach($products as $product):?>
            <div><?php echo Html::a(Html::encode($product->title), ['/product', 'entity' => $product]); ?></div> 
            <div>
                <?php if(isset($files[$product->id][0])):?>
                    <?php $file = $files[$product->id][0]; ?>
                    <?php echo Html::a(Html::img('/'.StyleHelper::getPreviewUrl($file, '130x130')),['/product', 'entity' => $product]);?>
                <?php endif;?>
            </div>
            <div><?php echo Html::encode($product->short); ?></div>
            <div><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></div>
            <div><?php echo CartHelper::getBuyButton($product);?></div>
        <?php endforeach; ?>
        <?=LinkPager::widget(['pagination' => $dataProvider->pagination, 'linkOptions' => ['href' => 'zzz']]); ?>
        <?=CartHelper::getConfirmModal();?>
    </div>
    <div class="col-lg-4">
        <?=FilterWidget::widget(['search' => $search]);?>
    </div>
</div>




