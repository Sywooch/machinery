<?php

namespace common\models;

use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\validators\TaxonomyAttributeValidator;
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
//    public $category;
//    public $cats_tmp = [];

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
            [['created', 'updated', 'published'], 'safe'],
            [['status', 'maderated'], 'boolean'],
            [['title', 'website', 'manufacture', 'phone', 'model'], 'string', 'max' => 255],
            [['photos'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 2],
            [['category'], TaxonomyAttributeValidator::class, 'type' => 'integer']
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

    public function getCategories(){
        return $this->hasMany(TaxonomyItems::className(), ['id'=>'term_id'])
            ->where(['vid'=>2])
            ->viaTable('{{%taxonomy_index}}', ['entity_id' => 'id'])
            ->indexBy('id')
//            ->column('tid')
            ->asArray();
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->updated = time();
            $this->created = time();
        } else {
            $this->updated = time();
        }
        $this->published = Yii::$app->formatter->asTimestamp($this->published);

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
}
