<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\modules\cart\Asset;
use kartik\checkbox\CheckboxX;
use common\modules\product\widgets\PromoCode\PromoCodeWidget;


Asset::register($this);

$this->title = 'Корзина';

$total = 0;
?>

<?php if($cart->order && count($cart->order->items)):?>

<div class="row cart-page">
    <div class="col-lg-8">
        <h1>Корзина</h1>
        <ul class="order_steps"><li class="selected">Сборка заказа</li><li>Способ и адрес доставки</li><li>Способ оплаты</li><li>Подтверждение и оплата</li></ul>
        <?php $form = ActiveForm::begin([
            'id' => 'cart-form',

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
 
        <?=$this->render('_items',['cart' => $cart, 'form' => $form]);?>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-lg-4">


            <div class="order-panel">
                <div class="order-panel-conteiner">
                    <span class="lb">Сумма к оплате</span>
                    <span class="cart-total"><?php echo \Yii::$app->formatter->asCurrency($total); ?></span>
                </div>
                <?=PromoCodeWidget::widget();?>
                <?php if(!Yii::$app->user->id):?>
                    <div class="order-panel-info">
                        Если вы имеете клубную карту и совершали ранее покупки,
                        то <a href="/login">Авторизуйтесь</a>, чтобы узнать сумму бонусов
                        доступную для скидки.
                    </div>
                <?php endif;?>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'preorder-form'
                    ]); ?>
                    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary btn-orange-big']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
              </div>

    </div>
</div>
<?php else:?>
    <h1> Корзина</h1>
    <div class="cart-empty">Корзина пуста</div>
    
<?php endif;?>
