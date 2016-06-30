<?php

namespace console\modules\import\helpers;

use Yii;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;

class ImportHelper
{
    private $taxonomyVocabularyModel;
    private $taxonomyItemsModel;
    private $termsTree = [];
    private $vocabularies = [];
    private $idToVocabulary = [];


    public function __construct(TaxonomyVocabulary $taxonomyVocabularyModel, TaxonomyItems $taxonomyItemsModel) {
        $this->taxonomyVocabularyModel = $taxonomyVocabularyModel;
        $this->taxonomyItemsModel = $taxonomyItemsModel;
    }
    
    public function termsIndex(&$data){
        $tree = $this->getTermsTree($data);
        
        print_r($data); exit();
    }

    private function getTermsTree($data){
        
        $temporary = array_column($data, 'terms');

        foreach($temporary as $terms){
            $this->termsTree = array_replace_recursive($terms, $this->termsTree);
        }
        
        $temporary = [];
        foreach($this->termsTree as $vocabulary => $terms){
            if(!key_exists($vocabulary, $this->vocabularies)){
               $this->vocabularies[$vocabulary] = $this->taxonomyVocabularyModel->find()->where(['name' => $vocabulary])->one();
               $this->idToVocabulary[$this->vocabularies[$vocabulary]->id] = $this->vocabularies[$vocabulary]->name;
            }
            
            foreach($terms as $term => $value){
                if(!$value){
                   $temporary[$this->vocabularies[$vocabulary]->id][] = $term;
                }
            }
        }
        
        if(empty($temporary)){
            return $this->termsTree;
        }
        
        $termsData  = [];
        foreach($temporary as $vid => $terms){
            $termsData[$vid] = $this->taxonomyItemsModel->find()->indexBy('id')->where(['vid' => $vid])->andWhere(['in', 'name', $terms])->all();
        }
        unset($temporary);
        
        foreach($termsData as $terms){
            foreach($terms as $term){
                $vocabulary = $this->idToVocabulary[$term->vid];
                $this->termsTree[$vocabulary][$term->name] = $term->id;
            }
        } 
        
        return $this->termsTree;
    }


    public function parseTerms($line){
        $terms = [];
        
        if(!key_exists('terms', $line)){
            return false;
        }
        
        $temporary = str_replace('"', '', $line['terms']);
        
        if($temporary == ''){
            return false;
        }
        
        $temporary = explode(';', $temporary);
        
        if(empty($temporary)){
            return false;
        }
        
        foreach($temporary as $item){
            list($vocabulary, $term) = explode(':', $item);
            $terms[$vocabulary][$term] = null;
        }
        
        if(empty($terms)){
            return false;
        }
        
        $line['terms'] = $terms;
        return $line;
    }
}

