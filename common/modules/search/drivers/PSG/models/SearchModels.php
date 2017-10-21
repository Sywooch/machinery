<?php

namespace common\modules\search\drivers\PSG\models;

use Yii;

/**
 * This is the model class for table "search_models".
 *
 * @property integer $id
 * @property string $class
 */
class SearchModels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search_models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model'], 'required'],
            [['model'], 'string', 'max' => 255],
            [['model'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
        ];
    }
}
