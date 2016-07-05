<?php

namespace console\modules\import\helpers;

use Yii;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;

class ImportHelper
{
    private $taxonomyVocabularyModel;
    private $taxonomyItemsModel;

    public function __construct(TaxonomyVocabulary $taxonomyVocabularyModel, TaxonomyItems $taxonomyItemsModel) {
        $this->taxonomyVocabularyModel = $taxonomyVocabularyModel;
        $this->taxonomyItemsModel = $taxonomyItemsModel;
    }
    
    public static function deleteTermsData(array $sku2Ids, array $currentTermIds, array $newTermIds){
        $data = [];
        foreach($sku2Ids as $sku => $entityId){
            $new = array_column($newTermIds[$sku], 'id');
            $current = $currentTermIds[$entityId];
            $current[] = 233;
            $data[$entityId] = array_diff($current, $new);
        }
        return $data;
    } 
    
    public function insetTermsData(array $sku2Ids, array $currentTermIds, array $newTermIds){
        $data = [];
        $vocabularyFields = Yii::$app->params['catalog']['vocabularyFields'];
        foreach($sku2Ids as $sku => $entityId){
            foreach($newTermIds[$sku] as $term){
               $data[] = [
                    'term_id' => $term['id'],
                    'entity_id' => $entityId,
                    'field' => isset($vocabularyFields[$term['vid']]) ? $vocabularyFields[$term['vid']] : $vocabularyFields['all']
                ]; 
            }
        }
        return $data;
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
    
    public static function productFieldTypes(){
        return [
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT
        ];
    }
    public static function productFields(){
        return [
                   'sku',
                   'price',
                   'title',
                   'description',
                   'reindex',
                   'user_id',
                   'source_id'
               ];
    }
    public static function termFieldTypes(){
        return [
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_STR
        ];
    }
    public static function termFields(){
        return [
                   'term_id',
                   'entity_id',
                   'field'
               ];
    }
}

