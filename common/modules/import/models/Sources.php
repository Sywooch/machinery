<?php

namespace common\modules\import\models;

use Yii;
use common\modules\import\models\Validate;
use backend\models\ProductDefault;

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
 * @property ProductDefault[] $ProductDefaults
 */
class Sources extends \yii\db\ActiveRecord
{
    const TIRES = 500;
    const STATUS_ACTIVE = 1;
    const STATUS_PAUSE = 0;
    
    private $_file;
    private $_fields;
    private $_messages;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_sources';
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
        $this->_messages = [];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDefaults()
    {
        return $this->hasMany(ProductDefault::className(), ['source_id' => 'id']);
    }

    public function addMessage($message, Validate $validate = null){
        if($validate){
            $message = "[{$validate->sku}] ".$message;
        }
        $this->_messages[] = $message;
        return $message;
    }

    public function countMessages(){
        return count($this->_messages);
    }

    public function getMessages($message){
        return $this->messages;
    }

    public function open(){ 
        $this->_file = @fopen(Yii::getAlias('@app').'/../files/import/source_' . $this->id . '_' . date('Y-m-d') . '.csv', 'r');
        return $this->_file;
    }
    
    public function close(){
        fclose($this->_file);
    }




    public function read(){
        if(!$this->_file){
            return false;
        }
        
        $line = fgetcsv($this->_file, 20000, ";");
        if($line !== false && empty($this->_fields)){
            $this->_fields = $line;
            $line = fgetcsv($this->_file, 20000, ";");
        }
        if($line !== false){
            array_walk($line, function(&$item){
               $item = rtrim(trim($item, '"'),'"');
            });
            if(count($this->_fields) != count($line)){
              return [];
            }
            $line = array_combine($this->_fields, $line);
        }
        return $line;
    }
}
