<?php

namespace common\modules\import\models;

use Yii;

/**
 * This is the model class for table "import_image".
 *
 * @property integer $id
 * @property string $data
 */
class ImportImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data'], 'required'],
            [['data'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
        ];
    }
}
