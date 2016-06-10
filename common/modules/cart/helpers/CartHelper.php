<?php

namespace common\modules\cart\helpers;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\Modal;

class CartHelper
{
    /**
     * 
     * @param int $entityId
     * @param int $catalogId
     * @return string
     */
    public static function getBuyButton($entityId, $catalogId){
       return Html::button ( Yii::$app->params['catalog']['buyButtonText'], [
           'entityId' => $entityId,
           'catalogId' => $catalogId,
           'class' => [
                'btn',
                'btn-primary',
                'buy-button',
                'buy-button-'.$entityId
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

