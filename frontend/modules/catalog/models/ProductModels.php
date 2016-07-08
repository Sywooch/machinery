<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "product_models".
 *
 * @property integer $id
 * @property integer $term_id
 * @property string $source
 */
class ProductModels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'source'], 'required'],
            [['term_id'], 'integer'],
            [['source'], 'string', 'max' => 255],
            [['term_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term_id' => 'Term ID',
            'source' => 'Source',
        ];
    }
}
