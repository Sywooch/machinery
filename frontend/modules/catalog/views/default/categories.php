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
                <?=$this->render('_itemB',[
                    'product' => $product
                ]);?>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>
        
    </div>
</div>
<?=CartHelper::getConfirmModal();?>




