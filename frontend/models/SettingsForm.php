<?php

namespace frontend\models;

use yii;
use dektrium\user\models\SettingsForm as SettingsFormBase;

class SettingsForm extends SettingsFormBase
{
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['password_repeat', 'required'];
        $rules[] = ['password_repeat', 'compare', 'compareAttribute' => 'new_password', 'message' => Yii::t('user', 'Passwords don\'t match')];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['password_repeat'] =  Yii::t('user', 'Password repeat');
        return $labels;
    }
}
