<?php

namespace common\modules\taxonomy\models;

use Yii;
use common\modules\taxonomy\models\TaxonomyVocabulary;

/**
 * This is the model class for table "taxonomy_items".
 *
 * @property integer $id
 * @property integer $vid
 * @property integer $pid
 * @property string $name
 * @property integer $weight
 */
class TaxonomyItems extends \yii\db\ActiveRecord
{
    
    const TABLE_TAXONOMY_ITEMS = 'taxonomy_items';
    
    private $_parent;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_TAXONOMY_ITEMS;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid', 'name'], 'required'],
            [['vid', 'pid', 'weight'], 'integer'],
            [['name','transliteration'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        if(!$this->transliteration){
            \URLify::add_chars (array (',' => '.', '_' => '-' ));
            $this->transliteration = \URLify::filter (\URLify::downcode ($this->name), 60, "", true);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vid' => 'Vid',
            'pid' => 'Pid',
            'name' => 'Name',
            'weight' => 'Weight',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVocabulary()
    {
        return $this->hasOne(TaxonomyVocabulary::className(), ['id' => 'vid']);
    }
    
    public function getParent(){
        if(!$this->pid){
            return false;
        }
        if($this->_parent){
           return $this->_parent; 
        }
        $this->_parent = self::findOne($this->pid);
        return $this->_parent;
    }
}
