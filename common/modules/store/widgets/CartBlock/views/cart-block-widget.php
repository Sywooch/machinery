
<div id="cart-block-widget">
    
    <a href="/store/cart">
        <span class="mif-shopping-basket"></span> 
        <span class="cart-items"><?php
            echo \Yii::t('app', '{n, plural, =0{Корзина} one{# товар} few{# товара} many{# товаров} other{# товаров}}', array(
                'n' => $order ? $order->count : 0
            ));
        ?></span>
    </a>
    <span class="cart-total"><?= Yii::$app->formatter->asCurrency($order ? $order->price : 0); ?></span>
   
</div>