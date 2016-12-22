<?php

namespace common\modules\import\models;

use Yii;
use common\modules\import\models\TemporaryTerms;
use yii\helpers\ArrayHelper;
use common\modules\product\helpers\ProductHelper;
use common\modules\import\models\Sources;

/**
*
 */
class Validate extends \yii\base\Model
{   
    public $id;
    public $sku;
    public $group;
    public $model;
    public $title;
    public $description;
    public $short;
    public $features;
    public $terms;
    public $index;
    public $price;
    public $user_id;
    public $source_id;
    public $images;
    public $publish;
    public $url;
    public $available;

    private $_catalogId;
    private $_temporaryTerms;
    private $_source;

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
            [['model'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 255],
            [['terms'], 'validateTerms'],
            [['price'], 'double'],
            [['images'], 'safe']
        ];
    }
    
    public function beforeValidate() { 
        $this->id = 1;
        $this->publish = 1;
        $this->available = 1;
        $this->user_id = 1;
        $this->source_id = $this->_source->id;
        $this->group = ProductHelper::createGroup($this->attributes);

        if($this->terms === false){
            $this->addError('terms', '[1001] Ошибка парсинга терминов.');  
            return false;
        }
        
        if($this->images === false){
            $this->addError('terms', '[1002] Ошибка парсинга изображений.'); 
            return false;
        }
        
        return parent::beforeValidate();
    }
    
    public function setDefault(){
        foreach($this->attributes as $name => $value){
            $this->$name = null;
        }
    }

    public function afterValidate() { 
        if(!$this->attributes['terms']){
            var_dump($this->attributes); exit();
        }
        $this->index = ArrayHelper::getColumn($this->attributes['terms'], 'id');
        $this->_catalogId = ArrayHelper::getValue($this->attributes,'terms.0.id');
        return parent::afterValidate();
    }
    
    public function getCatalogId(){
        return $this->_catalogId;
    }
    
    public function setTemporaryTerms(TemporaryTerms $temporaryTerms){
        $this->_temporaryTerms = $temporaryTerms;
    }
    
    public function setSource(Sources $source){
        $this->_source = $source;
    }


    public function validateTerms($attribute, $params){
       
        $rootTerm = [];
        $data = $this->_temporaryTerms->getTerms($this->$attribute); 
       
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
        $this->terms = array_merge($rootTerm, $data);           
    }

}
