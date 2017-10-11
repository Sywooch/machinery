<?php

namespace common\models;

use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\validators\TaxonomyAttributeValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Advert extends \yii\db\ActiveRecord
{

    const VCL_CATEGORIES = 2;
    const VCL_MANUFACTURES = 3;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \common\modules\file\components\FileBehavior::class,
            ],
            [
                'class' => \common\modules\taxonomy\behaviors\TaxonomyBehavior::class,
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated','published'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated','published'],
                ]
            ]
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
            [['title', 'website', 'price', 'manufacture', 'phone', 'model', 'category'], 'required'],
            [['body', 'bucket_capacity', 'tire_condition', 'serial_number', 'lang', 'meta_description'], 'string'],
            [['price'], 'number'],
            [['currency', 'year', 'condition', 'operating_hours', 'mileage', 'parent'], 'integer'],
            [['created', 'updated', 'published','order_options', 'manufacture'], 'safe'],
            [['status', 'maderated'], 'boolean'],
            [['title', 'website', 'phone', 'model', 'meta_description'], 'string', 'max' => 255],
            [['photos'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 2],
            [['category'], TaxonomyAttributeValidator::class, 'type' => 'integer'],
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

    public function getOptions(){
        return $this->hasMany(TarifOptions::className(), ['id'=>'option_id'])
            ->viaTable('{{%advert_option}}', ['advert_id'=>'id'])
            ->indexBy('id')
            ->orderBy(['weight'=>'asc']);
    }

    public function getCategories(){
        return $this->hasMany(TaxonomyItems::className(), ['id'=>'term_id'])
            ->where(['vid'=>2])
            ->viaTable('{{%taxonomy_index}}', ['entity_id' => 'id'])
            ->indexBy('id')
//            ->column('tid')
            ->asArray();
    }
    public function getVariant(){
        return $this->hasMany(AdvertVariant::className(), ['advert_id'=>'id'])
            ->indexBy('lang');
    }


    public function beforeSave($insert)
    {
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

//        $cat_key = array_keys($this->categories);
//        $remove_ch_ids = array_diff($cat_key, $this->category);
//        $add_ch_ids = array_diff($this->category, $cat_key);
//
//        echo "<pre> Уже есть - ",print_r($cat_key, 1), "</pre>";
//        echo "<pre> Пришли в форме - ",print_r($this->category, 1), "</pre>";
//        echo "<pre> Пришли новые - ",print_r($add_ch_ids, 1), "</pre>";
//        echo "<pre> Надо удалить - ",print_r($remove_ch_ids, 1), "</pre>";
//        die();
    }


    /**
     * @return mixed
     */
    public function getAdvertOrderOptions()
    {
        return  json_decode($this->order_options) ;
    }

}
