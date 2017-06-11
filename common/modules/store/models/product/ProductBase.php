<?php

namespace common\modules\store\models\product;

use yii\db\ActiveRecord;
use common\modules\import\models\Sources;
use common\modules\taxonomy\validators\TaxonomyAttributeValidator;

class ProductBase extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'user_id', 'available', 'group'], 'integer'],
            [['sku', 'title', 'cid'], 'required'],
            [['price', 'real_price', 'old_price', 'rating'], 'number'],
            [['description', 'data', 'short', 'features'], 'string'],
            [['sku'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 255],
            [['sku'], 'unique'],
            [['index'], TaxonomyAttributeValidator::class],
            [['cid'], TaxonomyAttributeValidator::class, 'type' => 'integer'],
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

}

