<?php

namespace common\modules\store\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;

class CartHelper
{
    /**
     * 
     * @param int $entityId
     * @param int $catalogId
     * @return string
     */
    public static function getBuyButton($product){
       return '<div class="buy-btn-conteiner">'.Html::button ( Yii::$app->params['catalog']['buyButtonText'], [
           'entityId' => $product->id,
           'entity' => StringHelper::basename(get_class($product)),
           'class' => [
                'btn',
                'btn-default',
                'buy-button',
                'buy-button-'.$product->id
            ]
       ]).'</div>';
    }
    
}

