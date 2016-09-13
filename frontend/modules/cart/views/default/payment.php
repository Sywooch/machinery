<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use frontend\modules\cart\Asset;

Asset::register($this);


/* @var $this yii\web\View */
/* @var $model common\modules\orders\models\Orders */

$this->title = 'Способ оплаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row order-page">
    <div class="col-lg-8">

        <h1>Корзина</h1>
        <ul class="order_steps"><li ><a href="/cart">Сборка заказа</a></li><li><a href="/cart/default/order">Способ и адрес доставки</a></li><li class="selected">Способ оплаты</li><li>Подтверждение и оплата</li></ul>
        <h2>Выберите способ оплаты</h2>
        <?= $this->render('_form_pay', [
            'model' => $model
        ]) ?>
    
    </div>
    
    <div class="col-lg-4">
        <div class="order-panel">
                <div class="order-panel-conteiner">
                    <span class="lb">Сумма к оплате</span>
                    <span class="cart-total"><?php echo \Yii::$app->formatter->asCurrency($model->price); ?></span>
                </div>
        </div>
    </div>

</div>
