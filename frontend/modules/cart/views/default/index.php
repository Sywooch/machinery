<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\modules\cart\Asset;
use common\modules\file\helpers\FileHelper;
use common\modules\file\helpers\StyleHelper as Style;

Asset::register($this);

$this->title = 'Корзина';
/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'cart-form'
]); ?>

<?php foreach($order->ordersItems as $item):?>
<div class="row" id="order-item-<?=$item->id?>">
    <div class="col-lg-1 col-md-1 col-sm-1"><a href="/cart/default/remove?id=<?= $item->id ?>" class="cart-item-remove">x</a></div>
    <div class="col-lg-2 col-md-2 col-sm-2">
        <?php 
        if(isset($item->origin->photos) && !empty($item->origin->photos)){
            $img = Html::img(Style::getPreviewUrl($item->origin->photos[0], '130x130'), ['class' => 'img-responsive']);
        }else{
            $img = Html::img('/files/no-photo.png');
        }
        ?>
        <?= Html::a($img, ['/', 'id' => $item->entity_id], ['class' => '']); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5">
        <?= Html::a($item->title, ['/', 'id' => $item->entity_id], ['class' => '']); ?>
        <span class="price"><?=$item->price;?></span>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2" style="text-align:center;">
        <div class="input-group input-group-sm count-container" >
            <span class="input-group-addon ">
                <a href="/cart/default/count?id=<?= $item->id ?>&count=<?= $item->count - 1 ?>" class="cart-minus glyphicon glyphicon-minus"></a>
            </span>
            <?= $form->field($item, 'count', ['template' => '{input}'])->textInput(['data-id' => $item->id, 'data-type' => 'product', 'id' => 'order-item-count-' . $item->id, 'class' => 'form-control count-input']); ?>
            <span class="input-group-addon">
                <a href="/cart/default/count?id=<?= $item->id ?>&count=<?= $item->count + 1 ?>" class="cart-plus glyphicon glyphicon-plus"></a>
            </span>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2"><span class="item-total"><?=$item->price*$item->count;?></span></div>
</div>
<?php endforeach;?>

<?php ActiveForm::end(); ?>