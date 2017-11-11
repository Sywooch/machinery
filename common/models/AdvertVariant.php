<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%advert_variant}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property integer $condition
 * @property integer $operating_hours
 * @property integer $mileage
 * @property string $bucket_capacity
 * @property boolean $status
 * @property boolean $maderated
 * @property string $lang
 * @property integer $advert_id
 * @property string $meta_description
 */
class AdvertVariant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advert_variant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['body', 'bucket_capacity'], 'string'],
            [['condition', 'operating_hours', 'mileage', 'advert_id'], 'integer'],
            [['status', 'maderated'], 'boolean'],
            [['title', 'meta_description'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 6],
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
            'body' => Yii::t('app', 'Body'),
            'condition' => Yii::t('app', 'Condition'),
            'operating_hours' => Yii::t('app', 'Operating Hours'),
            'mileage' => Yii::t('app', 'Mileage'),
            'bucket_capacity' => Yii::t('app', 'Bucket Capacity'),
            'status' => Yii::t('app', 'Status'),
            'maderated' => Yii::t('app', 'Maderated'),
            'lang' => Yii::t('app', 'Lang'),
            'advert_id' => Yii::t('app', 'Advert ID'),
            'meta_description' => Yii::t('app', 'Meta Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return AdvertVariantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertVariantQuery(get_called_class());
    }
}
