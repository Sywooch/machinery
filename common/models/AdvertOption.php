<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advert_option".
 *
 * @property integer $id
 * @property integer $advert_id
 * @property integer $option_id
 *
 * @property Advert $advert
 * @property TarifOptions $option
 */
class AdvertOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advert_id', 'option_id'], 'integer'],
            [['advert_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advert::className(), 'targetAttribute' => ['advert_id' => 'id']],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => TarifOptions::className(), 'targetAttribute' => ['option_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advert_id' => 'Advert ID',
            'option_id' => 'Option ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvert()
    {
        return $this->hasOne(Advert::className(), ['id' => 'advert_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(TarifOptions::className(), ['id' => 'option_id']);
    }
}
