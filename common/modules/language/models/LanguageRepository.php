<?php

namespace common\modules\language\models;

use yii;

class LanguageRepository
{
    public function loadAll(){
        return Language::find()->all();
    }
}
