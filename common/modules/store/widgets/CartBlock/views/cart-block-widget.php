
<div id="cart-block-widget">
    
    <a href="/store/cart">
        <div>
            <span class="label">Кошик</span>
            <span class="cart-items">Товарів: <?=$order ? $order->count : 0;?></span>

            <!--span class="cart-total"><?php //Yii::$app->formatter->asCurrency($order ? $order->price : 0); ?></span-->
        </div>
        <span class="txt">Оформити замовлення</span>
    </a>

   
</div>