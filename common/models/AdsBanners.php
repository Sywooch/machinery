<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Inflector;

/**
 * This is the model class for table "ads_banners".
 *
 * @property integer $id
 * @property integer $region_id
 * @property integer $category_id
 * @property string $url
 * @property integer $status
 * @property integer $weight
 * @property integer $created
 * @property integer $updated
 */
class AdsBanners extends ActiveRecord
{

    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'category_id', 'status', 'weight', 'created', 'updated'], 'integer'],
            [['url', 'region_id'], 'required'],
            [['url'], 'string', 'max' => 255],
            [['banner'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'category_id' => 'Category ID',
            'url' => 'Url',
            'status' => 'Status',
            'weight' => 'Weight',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ]
            ],
            [
                'class' => \common\modules\file\components\FileBehavior::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->category_id = $this->category_id ? $this->category_id : 0;
        return parent::beforeSave($insert);
    }

}
