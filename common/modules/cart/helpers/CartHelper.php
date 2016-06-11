<?php

namespace common\modules\cart\helpers;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\helpers\ModelHelper;

class CartHelper
{
    /**
     * 
     * @param int $entityId
     * @param int $catalogId
     * @return string
     */
    public static function getBuyButton($product){
       return Html::button ( Yii::$app->params['catalog']['buyButtonText'], [
           'entityId' => $product->id,
           'entity' => ModelHelper::getModelName($product),
           'class' => [
                'btn',
                'btn-primary',
                'buy-button',
                'buy-button-'.$product->id
            ]
       ]);
    }
    
    public function getConfirmModal(){
        return Modal::widget([
            'id' => 'buyConfirmModal',
            'header' => '<h3>Вы добавили в корзину</h3>',
        ]);
    }
}

