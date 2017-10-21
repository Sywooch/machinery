<?php

namespace common\modules\communion\models;

use Yii;

/**
 * This is the model class for table "communion".
 *
 * @property integer $id
 * @property string $subject
 * @property boolean $status
 * @property string $create_at
 * @property string $closed_at
 * @property integer $user_id
 * @property integer $user_to
 */
class Communion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'communion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject'], 'required'],
            [['status'], 'boolean'],
            [['create_at', 'closed_at'], 'safe'],
            [['user_id', 'user_to'], 'integer'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'subject' => Yii::t('app', 'Subject'),
            'status' => Yii::t('app', 'Status'),
            'create_at' => Yii::t('app', 'Create At'),
            'closed_at' => Yii::t('app', 'Closed At'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_to' => Yii::t('app', 'User To'),
        ];
    }

    /**
     * @inheritdoc
     * @return CommunionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommunionQuery(get_called_class());
    }
}
