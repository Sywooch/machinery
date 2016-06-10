<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sources".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ProductPhone[] $productPhones
 */
class Sources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPhones()
    {
        return $this->hasMany(ProductPhone::className(), ['source_id' => 'id']);
    }
}
