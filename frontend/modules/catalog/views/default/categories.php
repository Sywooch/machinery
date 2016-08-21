<?php

use yii\helpers\Html;
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;
use common\modules\file\helpers\StyleHelper;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\rating\StarRating;

CartAsset::register($this);

$this->title = Html::encode($parent->name);
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => 'catalog'];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h1><?=Html::encode($parent->name);?></h1>
<div class="row catalog-category">
    <div class="col-lg-2" id="sub-menu">   
    </div>
    <div class="col-lg-10 sub-menu__items">
        <?php foreach($items as $item):?>
            <div class="category__item">
                <h2><a href="/<?=$parent->transliteration?>/<?=$item['term']->transliteration?>"><?=Html::encode($item['term']->name);?></a></h2>
                <?php foreach($item['products'] as $product):?>
                <div class="item">
                    <div>
                        <?php if(($file = ArrayHelper::getValue($item['files'], $product->id.'.0'))):?>
                            <?php echo Html::a(Html::img('/'.StyleHelper::getPreviewUrl($file, '130x130')),['/'.$item['aliases'][$product->id]->alias]);?>
                        <?php endif;?>
                    </div>
                    <?=Html::a(Html::encode($product->title), ['/'.$item['aliases'][$product->id]->alias],['class'=>'title']); ?>
                    <?= StarRating::widget([
                            'name' => 'rating_'.$product->id,
                            'value' => $product->groupRating,
                            'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
                        ]);
                    ?>
                    <div class="price"><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></div>
                    <div><?php echo CartHelper::getBuyButton($product);?></div>
                </div>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>
        
    </div>
</div>
<?=CartHelper::getConfirmModal();?>




