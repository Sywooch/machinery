<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;
use common\modules\file\helpers\StyleHelper;
use yii\widgets\Breadcrumbs;
use frontend\modules\catalog\widgets\Filter\FilterWidget;
use yii\helpers\ArrayHelper;

CartAsset::register($this);

$this->title = Html::encode($current->name);
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => '/catalog'];
$this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => '/'.$parent->transliteration];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h1><?=Html::encode($current->name);?></h1>
<div class="row">
    <div class="col-lg-8">
        <?php foreach($products as $product):?>
            <div><?php echo Html::a(Html::encode($product->title), ['/'.$product->url]); ?></div> 
            <div>
                <?php if(($file = ArrayHelper::getValue($product->files, '0'))):?>
                    <?php echo Html::a(Html::img('/'.StyleHelper::getPreviewUrl($file, '130x130')),['/'.$product->url]);?>
                <?php endif;?>
            </div>
            <div><?php echo Html::encode($product->short); ?></div>
            <div><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></div>
            <div><?php echo CartHelper::getBuyButton($product);?></div>
        <?php endforeach; ?>
        <?=LinkPager::widget(['pagination' => $dataProvider->pagination]); ?>
        <?=CartHelper::getConfirmModal();?>
    </div>
    <div class="col-lg-4">
        <?=FilterWidget::widget(['search' => $search]);?>
    </div>
</div>




