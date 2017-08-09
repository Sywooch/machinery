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
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['course'], 'number'],
            [['default', 'active'], 'boolean'],
            [['name', 'code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'course' => Yii::t('app', 'Course'),
            'default' => Yii::t('app', 'Default'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @inheritdoc
     * @return CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrencyQuery(get_called_class());
    }
}
