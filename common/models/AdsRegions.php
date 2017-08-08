<?php

namespace common\models;

use yii\helpers\Inflector;

/**
 * This is the model class for table "ads_regions".
 *
 * @property integer $id
 * @property string $name
 * @property string $price_front
 * @property string $price_category
 * @property string $price_subcategory
 * @property integer $status
 * @property integer $banner_count
 * @property string $transliteration
 */
class AdsRegions extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_regions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price_front', 'price_category', 'price_subcategory', 'banner_count'], 'required'],
            [['price_front', 'price_category', 'price_subcategory'], 'number'],
            [['status', 'banner_count'], 'integer'],
            [['name', 'transliteration', 'size'], 'string', 'max' => 255],
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
            'price_front' => 'Price Front',
            'price_category' => 'Price Category',
            'price_subcategory' => 'Price Subcategory',
            'status' => 'Status',
            'banner_count' => 'Banner Count',
            'transliteration' => 'Transliteration',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->transliteration = $this->transliteration ? $this->transliteration : str_replace([' '], ['-'], strtolower(Inflector::transliterate($this->name)));
        return parent::beforeSave($insert);
    }

}
