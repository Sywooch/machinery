<?php

namespace common\modules\product\models;

use Yii;

/**
 * This is the model class for table "product_short_settings".
 *
 * @property integer $id
 * @property integer $vocabulary_id
 * @property string $title
 */
class ProductShortSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_short_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vocabulary_id'], 'required'],
            [['vocabulary_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vocabulary_id' => 'Vocabulary ID',
            'title' => 'Title',
        ];
    }
}
