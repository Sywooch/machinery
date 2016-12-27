<?php

use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
use common\modules\store\helpers\ProductHelper;
use common\modules\file\helpers\StyleHelper as Style;
use common\modules\store\helpers\OrdersHelper;

?>

<?php foreach($order->items as $item):?>
<div class="row table-list-item cart-item" id="order-item-<?=$item->id?>">
    <div class="col-lg-2 col-md-2 col-sm-2 ">
        <?php if(isset($form)):?>
            <?=CheckboxX::widget([
                'name'=>'chb_'.$item->id,
                'options'=>['id'=>'chb_'.$item->id, 'class' => 'chb', 'data-id' => $item->id],
                'pluginOptions' => ['size'=>'xs', 'threeState' => false]
            ]);?>
        <?php endif;?>
        <?php 
        if(isset($item->origin->photos) && !empty($item->origin->photos)){
            $img = Html::img('/'.Style::getPreviewUrl($item->origin->photos[0], '100x100'), ['class' => 'img-responsive']);
        }else{
            $img = Html::img('/files/nophoto_100x100.jpg',['class' => 'img-responsive']);
        }
        ?>
        <?= Html::a($img, ['/'.$item->origin->url->alias], ['class' => '']); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <span class="product-status ">
                <?php foreach(ProductHelper::getStatuses($item->origin->terms) as $status):?>
                    <span class="<?=$status->transliteration;?>"><?=$status->name;?></span>
                <?php endforeach;?>
        </span>
        <?= Html::a($item->title, ['/'.$item->origin->url->alias], ['class' => '']); ?>
        <div class="info">
            <div class="sku">
                <span class="lb">Код</span>
                <?=$item->sku;?>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4" style="text-align:center;">
        <?php if(isset($form)):?>
        <div class="input-group input-group-sm count-container" >
            <?= $form->field($item, 'count', ['template' => '{input}'])->textInput(['data-id' => $item->id, 'data-type' => 'product', 'id' => 'order-item-count-' . $item->id, 'class' => 'form-control count-input']); ?>
            <span class="input-group-addon">
                шт.
            </span>
        </div>
        <a href="/store/cart/remove?id=<?= $item->id ?>" class="item-remove cart-item-remove"><i class="glyphicon glyphicon-remove-circle"></i></a>
        <?php endif;?>
        
        <span class="item-total">
                <?=  Yii::$app->formatter->asCurrency($item->price*$item->count);?>
        </span>
        <?php if(OrdersHelper::isPromo($order, $item)):?>
            <span class="item-old-total"><?=  Yii::$app->formatter->asCurrency($item->origin->price*$item->count);?></span>
            <span class="used-promo-code">Промо: <?=$item->origin->promoCode->code;?></span>
        <?php endif;?>
    </div>
</div>

<?php endforeach;?>
