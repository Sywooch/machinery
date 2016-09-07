<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;
use common\modules\file\helpers\StyleHelper;
use yii\widgets\Breadcrumbs;
use frontend\modules\catalog\widgets\Filter\FilterWidget;
use yii\helpers\ArrayHelper;
use kartik\rating\StarRating;

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
<div class="row catalog-list ">
    <div class="col-lg-8">
        <?=LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'nextPageLabel' => false,
            'prevPageLabel' => false,
           // 'maxButtonCount' => 4,
                ]); ?>
        <?php foreach($products as $product):?>
        <div class="item">
            <div class="left">
                <?= StarRating::widget([
                            'name' => 'rating_'.$product->id,
                            'value' => $product->rating,
                            'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
                        ]);
                ?>
                <?php if(($file = ArrayHelper::getValue($product->files, '0'))):?>
                    <?=Html::a(Html::img('/'.StyleHelper::getPreviewUrl($file, '130x130'),['class' => 'img-responsive']),['/'.$product->url->alias],['class' => 'img']);?>
                <?php else:?>
                    <?=Html::a(Html::img('/nophoto_100x100.jpg',['class' => 'img-responsive']),['/'.$product->url->alias],['class' => 'img']);?>
                <?php endif;?>
                <span class="comments-count"><a href="/<?=$product->groupUrl->alias;?>/otzyvy"><i class="glyphicon glyphicon-comment"></i><?=$product->comments;?> отзыва</a></span>
            </div>
            <div class="right">
                <?=Html::a(Html::encode($product->titleDescription), ['/'.$product->url->alias],['class'=>'title']); ?>
                <div class="produt-short"><?php echo Html::encode($product->short); ?></div>
                <div class="price-conteiner">
                    <span class="price"><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></span>
                    <?php echo CartHelper::getBuyButton($product);?>
                </div>
            </div>
        </div>    
        <?php endforeach; ?>
        <?=LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'nextPageLabel' => false,
            'prevPageLabel' => false,
           // 'maxButtonCount' => 4,
                ]); ?>
       
    </div>
    <div class="col-lg-4">
        <?=FilterWidget::widget(['search' => $search]);?>
    </div>
</div>
 <?=CartHelper::getConfirmModal();?>




