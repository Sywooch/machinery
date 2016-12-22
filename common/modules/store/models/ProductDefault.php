<?php

namespace common\modules\store\models;

use yii\db\ActiveRecord;
use common\modules\taxonomy\components\TermValidator;
use yii\behaviors\TimestampBehavior;
use common\modules\import\models\Sources;
use common\helpers\ModelHelper;
use common\modules\orders\models\PromoCodes;
use common\modules\orders\models\PromoProducts;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\file\models\File;

class ProductDefault extends ProductBase
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_default';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['index'], 'each', 'rule' => ['integer']],
            [['source_id', 'user_id', 'available'], 'integer'],
            [['sku', 'title', 'model'], 'required'],
            [['price','real_price','old_price', 'rating'], 'number'],
            [['description', 'data', 'short', 'features'], 'string'],
            [['sku'], 'string', 'max' => 30],
            [['model'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255],
            [['sku'], 'unique'],
            [['terms','catalog'], TermValidator::class],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \dektrium\user\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sources::className(), 'targetAttribute' => ['source_id' => 'id']],
            [['photos'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group' => 'Group',
            'model' => 'Model',
            'source_id' => 'Source ID',
            'user_id' => 'User ID',
            'sku' => 'Sku',
            'available' => 'Available',
            'price' => 'Price',
            'rating' => 'Rating',
            'publish' => 'Publish',
            'created' => 'Created',
            'updated' => 'Updated',
            'title' => 'Title',
            'short' => 'Short',
            'description' => 'Description',
            'data' => 'Data',
        ];
    }
    
    public static function populateRecord($model, $row){
        parent::populateRecord($model, $row);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => \common\modules\store\components\ProductBehavior::class,
                ],
                [
                    'class' => \common\modules\file\components\FileBehavior::class,
                ],
                [
                    'class' => \common\components\UrlBehavior::class,
                ],
                [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                    ]
                ]
            ];
    }
    
   
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Sources::className(), ['id' => 'source_id']);
    }
    
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getPromoCode()
    {
        return $this->hasOne(PromoCodes::className(), ['id' => 'code_id'])->viaTable(PromoProducts::tableName(), ['entity_id' => 'id'], function($query){
                $query->where(['model' => ModelHelper::getModelName(self::class)]);
            });
    }
    
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasOne(PromoProducts::className(), ['entity_id' => 'id'])->where(['model' => ModelHelper::getModelName(self::class)]);
    }
    
    /**
     * 
     * @return []
     */
    public function getFeature(){
        if(!$this->owner->features){
            return [];
        } 
        return json_decode($this->owner->features);
    }

    /**
     * 
     * @return [] File
     */
    public function getFiles(){
         return \common\modules\file\Finder::getInstances($this);
    }
    
    /**
     * 
     * @return string
     */
    public function getSpecification(){
        if($this->short){
            return $this->short;
        }
        $this->short = $this->helper->shortPattern($this);
        if($this->short){
            $this::updateAll(['short' => $this->short ], ['id' => $this->id]);
        }
        return $this->short;
    }
    
    
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasMany(TaxonomyItems::className(), ['id' => 'index']); 
    }
    
    /**
     * 
     * @param mixed $data
     */
    public function setTerms($data)
    {
        $this->terms = $data;
    }
    
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasMany(TaxonomyItems::className(), ['id' => 'index'])
                ->where(['vid' => 1]);
    }
    
    /**
     * 
     * @param mixed $data
     */
    public function setCatalog($data)
    {
        $this->catalog = $data;
    }
    
}

