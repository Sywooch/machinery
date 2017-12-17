<?php

namespace common\modules\search\drivers\PSG\models;

use Yii;

/**
 * This is the model class for table "search_words".
 *
 * @property integer $id
 * @property string $word
 */
class SearchWords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search_words';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word'], 'required'],
            [['word'], 'string', 'max' => 100],
            [['word'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Word',
        ];
    }
}
