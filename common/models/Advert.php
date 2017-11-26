<?php

namespace common\models;

use common\modules\comments\models\Comments;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\validators\TaxonomyAttributeValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\modules\file\Finder;

class Advert extends \yii\db\ActiveRecord
{

    const VCL_CATEGORIES = 2;
    const VCL_MANUFACTURES = 3;
    const VCL_COLOR = 5;

    public $translate;

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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated', 'published'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated', 'published'],
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
            [['title', 'manufacture', 'model', 'category'], 'required'],
            [['body', 'bucket_capacity', 'tire_condition', 'serial_number', 'lang', 'meta_description'], 'string'],
            [['price', 'power', 'weight', 'pressure','capacity','generatorOutput','voltage','tankVolume','length','width','height' ], 'number'],
            [['currency', 'year', 'condition', 'operating_hours', 'mileage', 'parent', 'status_user'], 'integer'],
            [['created', 'updated', 'published', 'order_options', 'manufacture'], 'safe'],
            [['status', 'maderated'], 'boolean'],
            [['title', 'website', 'phone', 'model', 'meta_description', 'reference_number'], 'string', 'max' => 255],
            [['photos'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 2],
            [['category'], TaxonomyAttributeValidator::class, 'type' => 'integer'],
            [['status_user'], 'default', 'value' => 1],
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
            'reference_number' => Yii::t('app', 'Reference number'),
            'power' => Yii::t('app', 'Power (HP)'),
            'weight' => Yii::t('app', 'Weight (kg)'),
            'pressure' => Yii::t('app', 'Pressure (bar)'),
            'capacity' => Yii::t('app', 'Capacity per hour (m³)'),
            'generatorOutput' => Yii::t('app', 'Generator output (kVA)'),
            'voltage' => Yii::t('app', 'Voltage'),
            'tankVolume' => Yii::t('app', 'Tank volume (l)'),
            'length' => Yii::t('app', 'Length (cm)'),
            'width' => Yii::t('app', 'Width (cm)'),
            'height' => Yii::t('app', 'Height (cm)'),
            'status_user' => Yii::t('app', 'Ad status'),
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

    /**
     *
     * @return [] File
     */
    public function getFiles()
    {
        return Finder::getInstances($this);
    }

    public function getOptions()
    {
        return $this->hasMany(TarifOptions::className(), ['id' => 'option_id'])
            ->viaTable('{{%advert_option}}', ['advert_id' => 'id'])
            ->indexBy('id')
            ->orderBy(['weight' => 'asc']);
    }

    public function getCategories()
    {
        return $this->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])
            ->where(['vid' => self::VCL_CATEGORIES])
            ->viaTable('{{%taxonomy_index}}', ['entity_id' => 'id'])
            ->indexBy('id')
//            ->column('tid')
            ->asArray();
    }

    public function getColor()
    {
        return $this->hasOne(TaxonomyItems::className(), ['id' => 'term_id'])
            ->where(['vid' => self::VCL_CATEGORIES])
            ->viaTable('{{%taxonomy_index}}', ['entity_id' => 'id']);
    }

    public function getVariant()
    {
        return $this->hasMany(AdvertVariant::className(), ['advert_id' => 'id'])
            ->indexBy('lang');
    }


    public function beforeSave($insert)
    {
        $categories = [];
        if($this->isNewRecord){
            $this->user_id = Yii::$app->user->id;
        }
//dd($this);
        foreach ($this->owner->category as $term) {
            $data = TaxonomyHelper::getParents($term);
            foreach ($data as $item){
                $categories[$item->id] = $item;
            }
        }

        $this->owner->category = $categories;

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
//        $translates =

        if(!$insert){
//            die('edit');
        } else {
//            die('new');
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

    }


    /**
     * @return mixed
     */
    public function getAdvertOrderOptions()
    {
        return json_decode($this->order_options);
    }

    public function getViewed(){
        return $this->hasMany(Viewed::className(), ['advert_id' => 'id'])->asArray();
    }
    public function viewedUpdate($id){
        $andWhere = !Yii::$app->user->isGuest ? ['user_id'=>Yii::$app->user->id] : ['user_ip' => Yii::$app->request->userIP];
        if(!$viewed = Viewed::find()->where(['advert_id'=>$id])->andWhere($andWhere)->one()) {
            $viewed = new Viewed();
            $viewed->advert_id = $id;
            $viewed->user_id = Yii::$app->user->id;
            $viewed->user_ip = Yii::$app->request->userIP;
        }
        $viewed->create_at = time();
        $viewed->save();
    }

    public function isAuthor($model){
        return $model->user_id == Yii::$app->user->id;
    }

    public function getOption($model, $option_id){
        if($options = json_decode($model->order_options)){
            if(in_array($option_id, $options)) return true;
        }
        return false;
    }

    public function getComments(){
        return $this->hasMany(Comments::className(), ['entity_id' => 'id'])->where(['model'=>'Advert']);
    }

}
