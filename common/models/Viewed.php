<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "viewed".
 *
 * @property integer $id
 * @property integer $advert_id
 * @property integer $user_id
 * @property string $create_at
 * @property string $user_ip
 */
class Viewed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'viewed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advert_id', 'user_id'], 'integer'],
            [['create_at'], 'safe'],
            [['user_ip'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'advert_id' => Yii::t('app', 'Advert ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'create_at' => Yii::t('app', 'Create At'),
            'user_ip' => Yii::t('app', 'User Ip'),
        ];
    }

    /**
     * @inheritdoc
     * @return ViewedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ViewedQuery(get_called_class());
    }

    public function getAdvert()
    {
        return $this->hasOne(Advert::className(), ['id' => 'advert_id']);
    }
}
