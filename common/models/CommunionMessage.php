<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "communion_message".
 *
 * @property integer $id
 * @property integer $communion_id
 * @property boolean $status
 * @property string $create_at
 * @property string $ready
 * @property integer $user_id
 * @property string $body
 */
class CommunionMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'communion_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['communion_id', 'user_id'], 'integer'],
            [['status'], 'boolean'],
            [['create_at', 'ready'], 'safe'],
            [['body'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'communion_id' => Yii::t('app', 'Communion ID'),
            'status' => Yii::t('app', 'Status'),
            'create_at' => Yii::t('app', 'Create At'),
            'ready' => Yii::t('app', 'Ready'),
            'user_id' => Yii::t('app', 'User ID'),
            'body' => Yii::t('app', 'Body'),
        ];
    }

    /**
     * @inheritdoc
     * @return CommunionMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommunionMessageQuery(get_called_class());
    }
}
