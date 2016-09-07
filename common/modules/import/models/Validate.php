<?php

namespace common\modules\import\models;

use Yii;
use common\modules\import\components\Reindex;
use common\modules\import\helpers\ImportHelper;

/**
*
 */
class Validate extends \yii\base\Model
{   
    public $sku;
    public $group;
    public $model;
    public $title;
    public $description;
    public $short;
    public $features;
    public $terms;
    public $termIds;
    public $price;
    public $user_id;
    public $source_id;
    public $images;
    public $publish;
    public $url;

    private $_catalogId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'title', 'price', 'source_id', 'user_id', 'model','group'], 'required'],
            [['group','source_id', 'publish', 'user_id'], 'integer'],
            [['description', 'short', 'features'], 'string'],
            [['sku'], 'string', 'max' => 20],
            [['model'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 255],
            [['terms'], 'validateTerms'],
            [['price'], 'double'],
            [['images'], 'safe']
        ];
    }
    
    public function afterValidate() {
        $this->publish = 1;
        $this->_catalogId = \yii\helpers\ArrayHelper::getValue($this->attributes,'terms.0.id');
       
        return TRUE;
    }
    
    public function getCatalogId(){
        return $this->_catalogId;
    }
    
    public function validateTerms($attribute, $params){
        
        $rootTerm = [];
        $data = TemporaryTerms::getTermIds($this->$attribute); 

        if(count($this->$attribute, COUNT_RECURSIVE) - count($this->$attribute) !== count($data)){  
            
            $vocabularies = $this->$attribute;
            
            foreach($data as $term){
                $termName = $term['name'];
                $vocabularyName = $term['vocabulary_name'];
                if(isset($vocabularies[$vocabularyName][$termName])){
                   unset($vocabularies[$vocabularyName][$termName]);
                }
            }
            
            $messages = [];
            foreach($vocabularies as $name => $terms){
                if(empty($terms)){
                    continue;
                }
                $messages[] = $name . ':'. implode('; ', array_keys($terms));
            }
            
            $this->addError($attribute, 'Не удалось распознать термины: '.  implode('; ', $messages));

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
        
        $this->terms = array_replace($rootTerm, $data);   
    }

}
