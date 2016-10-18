<?php

namespace common\modules\import\models;

use Yii;

/**
 * This is the model class for table "import_data".
 *
 * @property integer $id
 * @property string $sku
 * @property string $data
 */
class ImportData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'data'], 'required'],
            [['data'], 'string'],
            [['sku'], 'string', 'max' => 50],
            [['sku'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sku' => 'Sku',
            'data' => 'Data',
        ];
    }
}
