<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "alias".
 *
 * @property integer $id
 * @property string $url
 * @property string $alias
 * @property string $model
 */
class Alias extends \yii\db\ActiveRecord
{
    
    const TABLE_ALIAS = 'alias';
    const GROUP_MODEL = 'group';
    
    public $prefix;
    public $groupId;
    public $groupAlias;
    public $groupUrl;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_ALIAS;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'alias', 'model'], 'required'],
            [['url'], 'string', 'max' => 100],
            [['alias'], 'string', 'max' => 255],
            [['model'], 'string', 'max' => 50],
            [['alias', 'model'], 'unique', 'targetAttribute' => ['alias', 'model'], 'message' => 'The combination of Alias and Model has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'alias' => 'Alias',
            'model' => 'Model',
        ];
    }
    
    public function beforeSave($insert) {
        
        if($this->prefix){
           $this->alias = $this->prefix . DIRECTORY_SEPARATOR . $this->alias; 
        }
        if($this->groupAlias && $this->prefix){
           $this->groupAlias = $this->prefix . DIRECTORY_SEPARATOR . $this->groupAlias; 
        }

        $this->saveGroup(); 
        return parent::beforeSave($insert);
    }
    
    private function saveGroup(){
        if(!$this->groupAlias){
            return false;
        }
        
        $alias = self::find()->where([
            'model' => self::GROUP_MODEL,
            'alias' => $this->groupAlias
        ])->one();
        
        if(!$alias){
            $alias = \Yii::createObject([
                'class' => Alias::class,
                'entity_id' => $this->groupId,
                'url' => $this->groupUrl,
                'alias' => $this->groupAlias,
                'model' => self::GROUP_MODEL,
            ]);
            $alias->save();
        }
        
        return true;
    }
}
