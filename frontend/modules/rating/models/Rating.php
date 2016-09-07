<?php

namespace frontend\modules\rating\models;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $ip
 * @property integer $entity_id
 * @property string $model
 * @property double $rating
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'entity_id', 'model', 'rating'], 'required'],
            [['user_id', 'entity_id'], 'integer'],
            [['rating'], 'number'],
            [['ip'], 'string', 'max' => 16],
            [['model'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'entity_id' => 'Entity ID',
            'model' => 'Model',
            'rating' => 'Rating',
        ];
    }
}
