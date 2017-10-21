<?php

namespace common\modules\search\drivers\PSG\models;

use Yii;

/**
 * This is the model class for table "search_data".
 *
 * @property integer $id
 * @property integer $entity_id
 * @property integer $model_id
 * @property string $data
 */
class SearchData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'model_id', 'data'], 'required'],
            [['entity_id', 'model_id'], 'integer'],
            [['data'], 'string'],
            [['entity_id', 'model_id'], 'unique', 'targetAttribute' => ['entity_id', 'model_id'], 'message' => 'The combination of Entity ID and Model ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'model_id' => 'Model ID',
            'data' => 'Data',
        ];
    }
}
