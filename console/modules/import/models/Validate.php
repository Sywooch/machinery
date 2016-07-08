<?php

namespace console\modules\import\models;

use Yii;
use console\modules\import\models\TemporaryTerms;

/**
*
 */
class Validate extends \yii\base\Model
{
    public $sku;
    public $title;
    public $description;
    public $terms;
    public $termIds;
    public $price;
    public $reindex;
    public $user_id;
    public $source_id;
    public $images;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'title', 'price', 'source_id', 'user_id'], 'required'],
            [['source_id', 'reindex', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['sku'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255],
            [['terms'], 'validateTerms'],
            [['price'], 'double'],
            [['images'], 'safe']
        ];
    }
    
    public function afterValidate() {
        $this->reindex = 1;
    }
    
    public function validateTerms($attribute, $params){
        
        $rootTerm = [];
        $data = TemporaryTerms::getTermIds($this->$attribute); 
        
        if(count($this->$attribute, COUNT_RECURSIVE) - count($this->$attribute) !== count($data)){  
            $vocabularies = array_keys($this->$attribute);
            foreach($data as $term){
                if(($index = array_search($term['vocabulary_name'], $vocabularies)) !== false){
                    unset($vocabularies[$index]);
                }
            }
            $this->addError($attribute, 'Не удалось распознать термины словарей: '.  implode(', ', $vocabularies).'.');
            return;
        }
        
        foreach($data as $index => $term){
            if($term['pid'] == 0 && $term['vid'] == Yii::$app->params['catalog']['vocabularyId']){
                $rootTerm[] = $term;
                unset($data[$index]);
            }
        }
        
        if(count($rootTerm) !== 1){
            $this->addError($attribute, 'Не указан главный раздел или указано больше одного.');
            return;
        }
        
        $this->termIds = array_replace($rootTerm, $data);   
    }

}
