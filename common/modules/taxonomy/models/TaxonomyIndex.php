<?php

namespace common\modules\taxonomy\models;

use Yii;
use common\helpers\ModelHelper;
use common\modules\taxonomy\models\TaxonomyItems;

/**
 * This is the model class for table "taxonomy_index".
 *
 * @property integer $id
 * @property integer $term_id
 * @property integer $entity_id
 * @property string $field
 * @property string $model
 */
class TaxonomyIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'taxonomy_index';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term_id', 'entity_id', 'field', 'model'], 'required'],
            [['term_id', 'entity_id'], 'integer'],
            [['field', 'model'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term_id' => 'Term ID',
            'entity_id' => 'Entity ID',
            'field' => 'Field',
            'model' => 'Model',
        ];
    }
    
}
