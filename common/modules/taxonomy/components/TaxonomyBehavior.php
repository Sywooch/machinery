<?php

namespace common\modules\taxonomy\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\helpers\ModelHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyIndex;
use common\modules\taxonomy\helpers\TaxonomyHelper;

class TaxonomyBehavior extends Behavior
{
    public $indexModel;
    
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }
    
    public function afterInit() {
        parent::init();
        $termFields =  TaxonomyHelper::getTermFields($this->owner);
        foreach($termFields as $field => $rule){
            $this->$field = $this->getFiledsTerms($field);
        }
    }


    public function afterSave($event){
        
        $termFields = TaxonomyHelper::getTermFields($this->owner);
        foreach($termFields as $field => $rule){
            if(!empty($this->owner->$field)){
                if($this->indexModel){
                    $model = $this->indexModel;
                    $model::deleteAll([
                            'entity_id' => $this->owner->id,
                            'field' => $field
                        ]);
                    $this->_terms = TaxonomyItems::findAll(['id' => $this->owner->$field]);
                    foreach($this->_terms as $term){
                        \Yii::createObject([
                           'class' => $model,
                           'term_id' => $term->id,
                           'vocabulary_id' => $term->vid,
                           'entity_id' => $this->owner->id,
                           'field' => $field,
                        ])->save(); 
                    }
                }else{
                    TaxonomyIndex::deleteAll([
                        'entity_id' => $this->owner->id,
                        'model' => ModelHelper::getModelName($this->owner),
                        'field' => $field
                    ]);
                    $this->_terms = TaxonomyItems::findAll(['id' => $this->owner->$field]);
                    
                    foreach($this->_terms as $term){
                        \Yii::createObject([
                           'class' => TaxonomyIndex::class,
                           'term_id' => $term->id,
                           'entity_id' => $this->owner->id,
                           'field' => $field,
                           'model' => ModelHelper::getModelName($this->owner)
                        ])->save();  
                    }
                }
                $this->owner->$field = $this->_terms;
            }
        }
    }
    
    
    /**
     * 
     * @param string $field
     * @return object
     */
    private function getFiledsTerms($field){
        if($this->indexModel){      
            $model = $this->indexModel;   
            return $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable($model::tableName(), ['entity_id' => 'id'], function($query) use($field){
                $query->where(['field' => $field]);
            });
        }else{
            return $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable(TaxonomyIndex::tableName(), ['entity_id' => 'id'], function($query) use($field){
                $query->where(['field' => $field, 'model'=>  ModelHelper::getModelName($this->owner)]);
            });
        }
    }

}

?>