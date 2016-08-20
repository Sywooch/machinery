<?php

namespace frontend\modules\product\models;

use Yii;

/**
 * This is the model class for table "group_characteristics".
 *
 * @property integer $id
 * @property string $name
 */
class GroupCharacteristics extends \yii\db\ActiveRecord
{
    private $_vocabularies;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_characteristics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['vocabulary_ids','vocabularies'], 'safe'],
        ];
    }

    
    public function getVocabularies(){
        return json_decode($this->vocabulary_ids);
    }
    public function setVocabularies($data){
        $this->vocabulary_ids = json_encode($data);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
