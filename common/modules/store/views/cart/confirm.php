<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\modules\store\CartAsset;
use common\modules\store\helpers\ProductHelper;

CartAsset::register($this);

$this->title = 'Подтверждение заказа';

?>
<div class="row order-page">
    <div class="col-lg-8">
        <h1>Корзина</h1>
        <ul class="order_steps"><li ><a href="/cart">Сборка заказа</a></li><li><a href="/cart/default/order">Способ и адрес доставки</a></li><li ><a href="/cart/default/payment">Способ оплаты</a></li><li class="selected">Подтверждение и оплата</li></ul>
    
        <table class="table">
            <thead>
              <tr>
                <th>Товары</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($model->items as $item):?>
                    <tr>
                        <td><?= Html::a(ProductHelper::titlePattern($item->origin), ['/'.$item->origin->alias->alias, 'id' => $item->entity_id], ['class' => '']); ?></td>
                        <td><?=$item->count?> шт.</td>
                        <td>
                            <?=  Yii::$app->formatter->asCurrency($item->price*$item->count);?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
      </table>
        <p><i><span class="red">Внимание!</span> Окончательная стоимость заказа,
                    если в нем присутствуют товары и/или услуги, участвующие в акции,
                    будет подтверждена после обработки заказа сотрудником компании.</i>
        </p>
        <br/>
        <div class="grey">
            <?php $form = ActiveForm::begin([
                'id' => 'confirm-form'
            ]); ?>
            <?=$form->field($model,'comment')->textArea(['placeholder' => 'Дополнительная информация по заказу'])?>
            <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-orange-big']) ?>
            <?php ActiveForm::end(); ?>
        </div>  
    
    </div>
    
    <div class="col-lg-4">
        <div class="order-panel">
               
                <?php if($model->delivery == 'DeliveryDefault'):?>
                    <?=$this->render('_confirm_map',['model' => $model]);?>
                <?php endif;?>
        </div>
    </div>
</div>
