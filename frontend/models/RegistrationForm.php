<?php

namespace frontend\models;

use frontend\models\Profile;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use dektrium\user\models\User;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $name;
    public $birth;
    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
      
        $rules[] = ['name', 'required'];
        $rules[] = ['name', 'string', 'max' => 255];
        $rules[] = [['birth','phone'], 'string', 'max' => 100];
        unset($rules['usernameRequired']);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = 'ФИО';
        $labels['birth'] = 'Дата рождения';
        $labels['phone'] = 'Мобильный телефон';

        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function loadAttributes(User $user)
    {
    
        $parts = explode("@", $this->email);
        $this->username = $parts[0].time();
        
        $user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
        ]);
       
        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());
        
        $profile->setAttributes([
            'name' => $this->name,
            'birth' => $this->birth,
            'phone' => $this->phone,
        ]);
       
        $user->setProfile($profile);
        
    }
}
