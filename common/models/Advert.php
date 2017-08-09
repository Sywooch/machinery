<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advert".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $price
 * @property integer $currency
 * @property string $website
 * @property string $manufacture
 * @property string $phone
 * @property string $model
 * @property integer $year
 * @property integer $condition
 * @property integer $operating_hours
 * @property integer $mileage
 * @property string $bucket_capacity
 * @property string $tire_condition:
 * @property string $serial_number
 * @property string $created
 * @property string $updated
 * @property string $published
 * @property boolean $status
 * @property boolean $maderated
 */
class Advert extends \yii\db\ActiveRecord
{
    public $category;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \common\modules\file\components\FileBehavior::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'website', 'price', 'manufacture', 'phone', 'model'], 'required'],
            [['body', 'bucket_capacity', 'tire_condition', 'serial_number', 'lang'], 'string'],
            [['price'], 'number'],
            [['currency', 'year', 'condition', 'operating_hours', 'mileage', 'parent', 'category'], 'integer'],
            [['created', 'updated', 'published'], 'safe'],
            [['status', 'maderated'], 'boolean'],
            [['title', 'website', 'manufacture', 'phone', 'model'], 'string', 'max' => 255],
            [['photos'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 2],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'currency' => Yii::t('app', 'Currency'),
            'website' => Yii::t('app', 'Website'),
            'manufacture' => Yii::t('app', 'Manufacture'),
            'phone' => Yii::t('app', 'Phone'),
            'model' => Yii::t('app', 'Model'),
            'year' => Yii::t('app', 'Year'),
            'condition' => Yii::t('app', 'Condition'),
            'operating_hours' => Yii::t('app', 'Operating Hours'),
            'mileage' => Yii::t('app', 'Mileage'),
            'bucket_capacity' => Yii::t('app', 'Bucket Capacity'),
            'tire_condition' => Yii::t('app', 'Tire Condition:'),
            'serial_number' => Yii::t('app', 'Serial Number'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'published' => Yii::t('app', 'Published'),
            'status' => Yii::t('app', 'Status'),
            'maderated' => Yii::t('app', 'Maderated'),
            'lang' => Yii::t('app', 'Language'),
            'category' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @inheritdoc
     * @return AdvertQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertQuery(get_called_class());
    }
}
