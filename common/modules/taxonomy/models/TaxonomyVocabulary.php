<?php

namespace common\modules\taxonomy\models;

use Yii;
use yii\validators\UniqueValidator;


/**
 * This is the model class for table "taxonomy_vocabulary".
 *
 * @property integer $id
 * @property string $name
 * @property string $prefix
 */
class TaxonomyVocabulary extends \yii\db\ActiveRecord
{
    const TABLE_TAXONOMY_VOCABULARY = 'taxonomy_vocabulary';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'taxonomy_vocabulary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['weight'], 'double'],
            [['name'], 'string', 'max' => 255],
            [['prefix'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'prefix' => 'Prefix',
            'weight' => 'Weight',
        ];
    }
    
    public function countTerms(){
        return (new \yii\db\Query())
            ->select('COUNT(*)')
            ->from(TaxonomyItems::TABLE_TAXONOMY_ITEMS)
            ->where(['vid' => $this->id])->scalar(); 
    }
}
