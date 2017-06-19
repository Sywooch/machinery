<?php

namespace common\models;

use yii;
use dektrium\user\models\LoginForm as LoginFormBase;

class LoginForm extends LoginFormBase
{
    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['captcha', 'required'];
        $rules[] = ['captcha', 'captcha'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['captcha'] = 'Код';
        $labels['login'] = Yii::t('app', 'Username');
        return $labels;
    }
}
