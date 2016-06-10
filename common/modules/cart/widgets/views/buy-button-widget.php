<?php
use yii\helpers\Html;
use common\helpers\ModelHelper;
?>
<div id="cart-buy-button-widget">
    <?php echo  Html::button('Купить',['class' => 'btn btn-primary buy-button', 'entityId' => $product->id, 'entity' => ModelHelper::getModelName($product)])?>
</div>