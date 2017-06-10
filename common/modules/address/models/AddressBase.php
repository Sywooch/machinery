<?php

namespace common\modules\address\models;

use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "address_street".
 *
 * @property integer $id
 * @property integer $locality_id
 * @property string $name
 * @property string $transliterate
 * @property double $longitude
 * @property double $latitude
 */
class AddressBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'longitude', 'latitude', 'address'], 'required'],
            [['longitude', 'latitude'], 'double'],
            [['parent_id'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['data', 'point'], 'safe'],
            [['transliterate', 'type'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'transliterate' => 'Transliterate',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
        ];
    }

    /**
     * @return AddressQuery
     */
    public static function find()
    {
        return new AddressQuery(get_called_class());
    }

}
