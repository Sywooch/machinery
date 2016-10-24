<?php

namespace common\modules\orders\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use dektrium\user\models\User;
use yii\db\ActiveRecord;

class Status extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statuses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'entity_id', 'from', 'to', 'updated_at'], 'integer'],
            [['entity_id', 'model', 'to', 'comment'], 'required'],
            [['comment'], 'string'],
            [['model'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Uid',
            'entity_id' => 'Entity ID',
            'model' => 'Model',
            'from' => 'From',
            'to' => 'To',
            'comment' => 'Comment',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function beforeValidate() {
        $this->user_id = Yii::$app->user->id;
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ]
                ]
            ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
