<?php

namespace common\modules\favorites\helpers;

use yii\db\ActiveRecordInterface;
use yii\helpers\Html;
use yii\helpers\StringHelper;


class FavoritesHelper
{

    public static function button(ActiveRecordInterface $entity)
    {
        return Html::button('', [
            'id' => 'favorite-entity-' . $entity->id,
            'class' => (isset($entity->favorite) && $entity->favorite ? 'active' : '') . ' glyphicon glyphicon-heart favorite-button',
            'data-id' => $entity->id,
            'data-entity' => StringHelper::basename(get_class($entity))
        ]);
    }

}
