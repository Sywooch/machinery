<?php

namespace frontend\models;

use dektrium\user\models\Profile as ProfileBase;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string  $name
 * @property string  $public_email
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $location
 * @property string  $website
 * @property string  $bio
 * @property string  $timezone
 * @property User    $user
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class Profile extends ProfileBase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['birth','phone'], 'string', 'max' => 100];
        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['birth'] = 'Дата рождения';
        $labels['phone'] = 'Мобильный телефон';
        return $labels;
    }
    
    public function afterFind() {
        if($this->birth){
            $this->birth = date("d.m.Y", strtotime($this->birth));
        }
        parent::afterFind();
    }
    
    public function validateTimeZone($attribute, $params)
    {
        if (!in_array($this->$attribute->getName(), timezone_identifiers_list())) {
            $this->addError($attribute, \Yii::t('user', 'Time zone is not valid'));
        }
    }

    public function beforeSave($insert) {
        if($this->birth){
            $this->birth = date("Y-m-d", strtotime($this->birth));
        }
        return parent::beforeSave($insert);
    }
}
