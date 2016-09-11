<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\modules\cart\Asset;
use common\modules\file\helpers\StyleHelper as Style;
use kartik\checkbox\CheckboxX;
use common\modules\product\widgets\PromoCode\PromoCodeWidget;


Asset::register($this);

$this->title = 'Корзина';
/* @var $this yii\web\View */
$this->params['breadcrumbs'][] = $this->title;

$total = 0;
?>

<?php if($cart->order && count($cart->order->items)):?>

<div class="row cart-page">
    <div class="col-lg-8">
        <h1> Корзина</h1>

        <?php $form = ActiveForm::begin([
            'id' => 'cart-form'
        ]); ?>
        
            <div class="row header">
                <div class="col-lg-6 col-md-6 col-sm-6"  id="chb-all-conteiner">
                    <?=CheckboxX::widget([
                        'name'=>'chb_all',
                        'options'=>['id' => 'chb_all'],
                        'pluginOptions' => ['size'=>'xs', 'threeState' => false]
                    ]);?>
                    <span id="multi-text"></span>
                     <?= Html::a('Удалить выбранное', ['#'], ['class' => 'btn btn-default ', 'id' => 'multi-delete-button']); ?>
                </div>
            </div>
 
        <?php foreach($cart->order->items as $item):?>
        <div class="row cart-item" id="order-item-<?=$item->id?>">
            <div class="col-lg-2 col-md-2 col-sm-2">
                
                <?=CheckboxX::widget([
                    'name'=>'chb_'.$item->id,
                    'options'=>['id'=>'chb_'.$item->id, 'class' => 'chb', 'data-id' => $item->id],
                    'pluginOptions' => ['size'=>'xs', 'threeState' => false]
                ]);?>

                <?php 
                if(isset($item->origin->photos) && !empty($item->origin->photos)){
                    $img = Html::img(Style::getPreviewUrl($item->origin->photos[0], '100x100'), ['class' => 'img-responsive']);
                }else{
                    $img = Html::img('/files/no-photo.png');
                }
                ?>
                <?= Html::a($img, ['/'.$item->origin->alias->alias, 'id' => $item->entity_id], ['class' => '']); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= Html::a($item->origin->titleDescription, ['/'.$item->origin->alias->alias, 'id' => $item->entity_id], ['class' => '']); ?>
                <div class="info">
                    <div class="sku">
                        <span class="lb">Код</span>
                        <?=$item->sku;?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4" style="text-align:center;">
                <div class="input-group input-group-sm count-container" >

                    <?= $form->field($item, 'count', ['template' => '{input}'])->textInput(['data-id' => $item->id, 'data-type' => 'product', 'id' => 'order-item-count-' . $item->id, 'class' => 'form-control count-input']); ?>
                    <span class="input-group-addon">
                        шт.
                    </span>
                </div>
            
                
                <a href="/cart/default/remove?id=<?= $item->id ?>" class="cart-item-remove"><i class="glyphicon glyphicon-remove-circle"></i></a>
                
                <?php if($cart->isPromoItem($item)):?>
                    <span class="item-total">
                        <?=  Yii::$app->formatter->asCurrency($item->origin->promoPrice*$item->count);?>
                    </span>
                    <span class="item-old-total"><?=  Yii::$app->formatter->asCurrency($item->price*$item->count);?></span>
                    <span class="used-promo-code">Промо: <?=$item->origin->promoCode->code;?></span>
                <?php else:?>
                    <span class="item-total"><?=  Yii::$app->formatter->asCurrency($item->price*$item->count);?></span>
                <?php endif;?>
                
                
            </div>
        </div>
        <?php $total +=  $item->price * $item->count; ?>
        <?php endforeach;?>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-lg-4">


            <div class="order-panel">
                <div class="order-panel-total">
                    <span class="lb">Сумма к оплате</span>
                    <span class="cart-total"><?php echo \Yii::$app->formatter->asCurrency($total); ?></span>
                </div>
                <?=PromoCodeWidget::widget();?>
                <div class="order-panel-info">
                    Если вы имеете клубную карту и совершали ранее покупки,
                    то <a href="/login">Авторизуйтесь</a>, чтобы узнать сумму бонусов
                    доступную для скидки.
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'preorder-form'
                    ]); ?>
                    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
              </div>

    </div>
</div>
<?php else:?>
    <h1> Корзина</h1>
    <div class="cart-empty">Корзина пуста</div>
    
<?php endif;?>
