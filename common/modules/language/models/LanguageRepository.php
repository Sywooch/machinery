<?php

namespace common\modules\language\models;

use yii;


class LanguageRepository
{
    const STATUS_ACTIVE = 1;
    const STATUS_DEFAULT = 1;

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

    public static function loadDefault(){
        return Language::find()->where(['default'=>self::STATUS_DEFAULT])->indexBy('local')->one();
    }
}
