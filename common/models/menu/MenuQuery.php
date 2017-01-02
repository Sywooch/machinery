<?php
namespace common\models\menu;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class MenuQuery extends \yii\db\ActiveQuery {
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}
