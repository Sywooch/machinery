<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $course
 * @property boolean $default
 * @property boolean $active
 */
class CurrencyRepository
{

    public static function changeDefault($id){
        if($model = Currency::find()->where(['id'=>$id])->one()){
            Currency::updateAll(['default'=>0]);
            $model->default = 1;
            if($model->save()) return true;
        }
        return false;
    }
}
