<?php

namespace backend\models;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;

/**
 * This is the model class for table "product_default_index".
 *
 * @property integer $term_id
 * @property integer $entity_id
 *
 * @property ProductDefault $entity
 * @property TaxonomyItems $term
 */
class ProductDefaultIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_default_index';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term_id', 'vocabulary_id', 'entity_id', 'field'], 'required'],
            [['term_id', 'entity_id', 'vocabulary_id',], 'integer'],
            [['field'], 'string', 'max' => 30],
            [['term_id', 'entity_id'], 'unique', 'targetAttribute' => ['term_id', 'entity_id'], 'message' => 'The combination of Term ID and Entity ID has already been taken.'],
            [['entity_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductDefault::className(), 'targetAttribute' => ['entity_id' => 'id']],
            [['term_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaxonomyItems::className(), 'targetAttribute' => ['term_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'term_id' => 'Term ID',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(ProductDefault::className(), ['id' => 'entity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(TaxonomyItems::className(), ['id' => 'term_id']);
    }
}
