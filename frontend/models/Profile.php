<?php

namespace frontend\models;

use yii;
use dektrium\user\models\Profile as ProfileBase;

class Profile extends ProfileBase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['phone'], 'string', 'max' => 100];
        $rules[] = [['last_name'], 'string', 'max' => 255];
        $rules[] = [['social'], 'each', 'rule' => ['string']];
        $rules['timeZoneValidation'] = ['timezone', 'safe'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('user', 'First name');
        $labels['social'] = Yii::t('user', 'Social media');
        $labels['last_name'] = Yii::t('user', 'Last name');
        $labels['phone'] = Yii::t('user', 'Phone');
        $labels['bio'] = Yii::t('user', 'About me / extra details');
        $labels['location'] = Yii::t('user', 'Country');
        return $labels;
    }

    /**
     * Validates the timezone attribute.
     * Adds an error when the specified time zone doesn't exist.
     * @param string $attribute the attribute being validated
     * @param array $params values for the placeholders in the error message
     */
    public function validateTimeZone($attribute, $params)
    {

    }

}
