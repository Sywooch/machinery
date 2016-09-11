<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
use common\modules\taxonomy\components\TermValidator;
use yii\behaviors\TimestampBehavior;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\import\models\Sources;
use yii\helpers\ArrayHelper;
use common\helpers\URLify;
use dektrium\user\models\User;
use common\helpers\ModelHelper;
use common\modules\product\models\PromoCodes;
use common\modules\product\models\PromoProducts;

/**
 * This is the model class for table "product_default".
 *
 * @property integer $id
 * @property integer $group
 * @property integer $source_id
 * @property integer $user_id
 * @property string $sku
 * @property integer $available
 * @property double $price
 * @property double $rating
 * @property integer $publish
 * @property integer $created
 * @property integer $updated
 * @property string $title
 * @property string $short
 * @property string $description
 * @property string $data
 *
 * @property User $user
 * @property Sources $source
 * @property ProductDefaultIndex[] $productDefaultIndices
 * @property TaxonomyItems[] $terms
 */
class ProductDefault extends ActiveRecord
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
            [['source_id', 'user_id', 'available'], 'integer'],
            [['sku', 'created', 'updated', 'title', 'model'], 'required'],
            [['price','old_price', 'rating'], 'number'],
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
    
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => \common\modules\taxonomy\components\TaxonomyBehavior::class,
                    'indexModel' => \backend\models\ProductDefaultIndex::class
                ],
                [
                    'class' => \common\modules\file\components\FileBehavior::class,
                ],
                [
                    'class' => \common\modules\product\components\ProductBehavior::class,
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
    
    public function getPromoPrice(){
        if(isset($this->promoCode)){
            return $this->price - $this->promoCode->discount;
        }
        return $this->price;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Sources::className(), ['id' => 'source_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromoCode()
    {
        return $this->hasOne(PromoCodes::className(), ['id' => 'code_id'])->viaTable(PromoProducts::tableName(), ['entity_id' => 'id'], function($query){
                $query->where(['model' => ModelHelper::getModelName(self::class)]);
            });
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasOne(PromoProducts::className(), ['entity_id' => 'id'])->where(['model' => ModelHelper::getModelName(self::class)]);
    }

    /**
     * 
     * @param \common\models\Alias $alias
     * @return \common\models\Alias
     */
    public function urlPattern(\common\models\Alias $alias){
        $alias->alias = URLify::url($this->titlePattern()) .'-'. $this->id;        
        $alias->groupAlias = URLify::url($this->title);
        $link = [];
        $link = array_column($this->catalog, 'transliteration');
        $alias->prefix = implode('/', $link);

        return $alias;
    }
    
    /**
     * 
     * @return string
     */
    public function shortPattern(){
        $terms = ArrayHelper::index($this->terms, 'vid');
        $short = [];
        $short[] = 'диагональ: '.ArrayHelper::getValue($terms, '32.name') . '"'; // display
        $short[] = ArrayHelper::getValue($terms, '36.name'); // OC
        $short = array_filter($short);
        return implode(',', $short);
    }
    
    /**
     * 
     * @return string
     */
    public function titlePattern(){
        $terms = ArrayHelper::index($this->terms, 'vid');
        $title = [];
        $title[] = $this->title;
        $title[] = ArrayHelper::getValue($terms, '36.name'); // OC
        $title[] = ArrayHelper::getValue($terms, '31.name'); // color
        $title = array_filter($title);
        return implode(' ', $title);
    }
}
