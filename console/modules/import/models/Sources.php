<?php

namespace console\modules\import\models;

use Yii;

/**
 * This is the model class for table "sources".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $url
 * @property integer $tires
 * @property string $date
 * @property string $messages
 *
 * @property ProductPhone[] $productPhones
 */
class Sources extends \yii\db\ActiveRecord
{
    private $_messages;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['tires'], 'integer'],
            [['date'], 'safe'],
            [['messages'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'url' => 'Url',
            'tires' => 'Tires',
            'date' => 'Date',
            'messages' => 'Messages',
        ];
    }
    
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            $this->messages = json_encode($this->_messages);
            return true;
        } else {
            return false;
        }
    }
    
    public function afterFind(){
        $this->_messages = json_decode($this->messages);
    }

    public function addMessage($message){
        $this->_messages[] = $message;
    }
    
    public function getMessages($message){
        return $this->_messages;
    }
}
