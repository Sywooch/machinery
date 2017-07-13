<?php

namespace common\modules\language\models;

use yii;

class LanguageRepository
{
    /**
     * @return array|yii\db\ActiveRecord[]
     */
    public function loadAll(){
        return Language::find()->all();
    }
}
