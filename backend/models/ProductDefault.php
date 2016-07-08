<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
use common\modules\file\models\File;
use common\modules\file\helpers\FileHelper;
use common\helpers\ModelHelper;
use common\modules\taxonomy\components\TermValidator;
use yii\behaviors\TimestampBehavior;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyIndex;
use console\modules\import\models\Sources;

/**
 * This is the model class for table "product_default".
 *
 * @property integer $id
 * @property integer $group_id
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
            [['group_id', 'source_id', 'user_id', 'available', 'publish', 'created', 'updated'], 'integer'],
            [['user_id', 'sku', 'created', 'updated', 'title'], 'required'],
            [['price', 'rating'], 'number'],
            [['description', 'data'], 'string'],
            [['sku'], 'string', 'max' => 30],
            [['title', 'short'], 'string', 'max' => 255],
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
            'group_id' => 'Group ID',
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
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                    ]
                ]
            ];
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

}
