<?php

namespace frontend\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use yii;

class RegistrationForm extends BaseRegistrationForm
{
    public $captcha;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['captcha', 'required'];
        $rules[] = ['captcha', 'captcha'];
        $rules[] = ['password_repeat', 'required'];
        $rules[] = ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user', 'Passwords don\'t match')];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['login'] =  Yii::t('user', 'Username');
        $labels['password_repeat'] =  Yii::t('user', 'Password repeat');
        return $labels;
    }
}
