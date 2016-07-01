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

