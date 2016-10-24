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

    public function __set($name, $value){
        $this->$name = $value;
    }
    

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_INIT => 'afterInit',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    
    public function afterDelete(){
        if($this->owner->indexModel){   
            $this->owner->indexModel->deleteAll(['entity_id' => $this->owner->id]);
        }else{
            TaxonomyIndex::deleteAll(['entity_id' => $this->owner->id, 'model' => ModelHelper::getModelName($this->owner)]);
        }
    }
    
    /**
     * 
     */
    public function afterInit() {
        $termFields =  TaxonomyHelper::getTermFields($this->owner);
        foreach($termFields as $field => $rule){
            $this->$field = $this->getFiledsTerms($field);
        }
        parent::init();
    }

    /**
     * 
     * @param type $event
     */
    public function afterSave($event){
        
        $termFields = TaxonomyHelper::getTermFields($this->owner);
        foreach($termFields as $field => $rule){
            if(!empty($this->owner->$field)){
                if($this->owner->indexModel){
                    $this->owner->indexModel->deleteAll([
                            'entity_id' => $this->owner->id,
                            'field' => $field
                        ]);
                    $this->_terms = TaxonomyItems::findAll(['id' => $this->owner->$field]);
                    foreach($this->_terms as $term){
                        $this->owner->indexModel->insert($term, $field);
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
    private function getFiledsTerms($field = null){
        if(isset($this->owner->indexModel) && $this->owner->indexModel){
            return $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable($this->owner->indexModel->tableName(), ['entity_id' => 'id'], function($query) use($field){
                $query->where(['field' => $field]);
            });
        }else{
            return $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable(TaxonomyIndex::tableName(), ['entity_id' => 'id'], function($query) use($field){
                $query->where(['field' => $field, 'model'=>  ModelHelper::getModelName($this->owner)]);
            });
        }
    }
    
    /**
     * 
     * @param string $field
     * @return object
     */
    public function getTerms($field = null){
        if(isset($this->owner->indexModel) && $this->owner->indexModel){ 
            return $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable($this->owner->indexModel->tableName(), ['entity_id' => 'id'], function($query) use($field){
                $query->filterWhere(['field' => $field]);
            });
        }else{
            return $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable(TaxonomyIndex::tableName(), ['entity_id' => 'id'], function($query) use($field){
                $query->filterWhere(['field' => $field, 'model'=>  ModelHelper::getModelName($this->owner)]);
            });
        }
    }

}

?>