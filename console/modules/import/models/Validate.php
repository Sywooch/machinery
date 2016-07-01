<?php

namespace console\modules\import\models;

use Yii;
use console\modules\import\models\Terms;

/**
*
 */
class Validate extends \yii\base\Model
{
    public $sku;
    public $name;
    public $description;
    public $terms;
    public $termIds;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'name'], 'required'],
            [['description'], 'string'],
            [['sku'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['terms'], 'validateTerms']
        ];
    }
    
    public function validateTerms($attribute, $params){
        
        $data = Terms::getTermIds($this->$attribute); 
  
        
        if(count($this->$attribute, COUNT_RECURSIVE) - count($this->$attribute) !== count($data)){
            $this->addError($attribute, 'Не удалось распознать термины.');
            return;
        }

        $this->termIds = array_column($data,'id');
    }

}
