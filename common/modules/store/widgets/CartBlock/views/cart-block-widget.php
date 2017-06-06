
<div id="cart-block-widget">
    
    <a href="/store/cart">
        <span class="mif-shopping-basket"></span> 
        <span class="cart-items"><?php
           
        ?></span>
    </a>
    <span class="cart-total"><?= Yii::$app->formatter->asCurrency($order ? $order->price : 0); ?></span>
   
</div>