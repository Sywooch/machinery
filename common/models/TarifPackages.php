<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tarif_packages".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property integer $term
 * @property string $options
 */
class TarifPackages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarif_packages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description', 'sub_caption'], 'string'],
            [['price'], 'number'],
            [['term', 'weight'], 'integer'],
            [['name', 'sub_caption'], 'string', 'max' => 255],
            [['status'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'options' => Yii::t('app', 'Options'),
            'term' => Yii::t('app', 'Срок действия'),
            'weight' => 'Позиция в списке',
            'sub_caption' => 'Sub Caption',
            'status' => 'Active',
        ];
    }
}
