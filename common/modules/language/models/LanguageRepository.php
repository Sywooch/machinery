<?php

namespace common\modules\language\models;

use yii;


class LanguageRepository
{
    const STATUS_ACTIVE = 1;

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    public function loadAll(){
        return Language::find()->all();
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    public function loadAllActive(){
        return Language::find()->where(['status'=>self::STATUS_ACTIVE])->indexBy('local')->all();
    }
}
