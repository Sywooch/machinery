<?php

namespace common\modules\import\helpers;

use Yii;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;
use common\helpers\ModelHelper;
use common\modules\import\models\ImportImage;
use finfo;
class ImportHelper
{
    private $taxonomyVocabularyModel;
    private $taxonomyItemsModel;
    private $finfo;

    public function __construct(TaxonomyVocabulary $taxonomyVocabularyModel, TaxonomyItems $taxonomyItemsModel) {
        $this->taxonomyVocabularyModel = $taxonomyVocabularyModel;
        $this->taxonomyItemsModel = $taxonomyItemsModel;
        $this->finfo = new finfo(FILEINFO_MIME_TYPE);
    }
    
    /**
     * 
     * @param ImportImage $image
     * @return []
     */
    public function copy(ImportImage $image){
        $data = json_decode($image->data);
        
        $time = time();
        $data->name  =  $time . '-' . basename($data->url);
        $path  = Yii::getAlias('@app') . '/../' . $data->path . DIRECTORY_SEPARATOR . $data->name;

        if(copy($data->url, $path)){
            $data->size = filesize ($path);
            $data->mimetype = $this->finfo->file($path);
            return $data;
        }
        return false;
    }

    /**
     * 
     * @param array $data
     * @return string
     */
    public static function getGroup($data){
        if(!isset($data['terms']['Бренд'])){
            return false;
        }
        $group = [];
        $group[] = key($data['terms']['Бренд']); // brend
        $group[] = $data['model'];
        return crc32(implode(' ', $group));
    }

    /**
     * 
     * @param array $sku2Ids
     * @param array $currentTermIds
     * @param array $newTermIds
     * @return type
     */
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
    
    public function insertTermsData(array $sku2Ids, array $currentTermIds, array $newTermIds){
        $data = [];
        $vocabularyFields = Yii::$app->params['catalog']['vocabularyFields'];
        foreach($sku2Ids as $sku => $entityId){
            foreach($newTermIds[$sku] as $term){
               $data[] = [
                    'term_id' => $term['id'],
                    'entity_id' => $entityId,
                    'vocabulary_id' => $term['vid'],
                    'field' => isset($vocabularyFields[$term['vid']]) ? $vocabularyFields[$term['vid']] : $vocabularyFields['all']
                ]; 
            }
        }
        return $data;
    }
    
    /**
     * 
     * @param object $model
     * @param array $links
     * @return string
     */
    public function insetUrlData($model, array $links){
        $data = [];
        $model = ModelHelper::getModelName($model);
        foreach($links as $id => $link){
            $data[] = [
                'entity_id' => (int) $id,
                'url' => 'product/default/?id=' . $id . '&model=' . $model,
                'alias' => $link,
                'model' => $model
            ]; 
        }
        return $data;
    }
    
    /**
     * 
     * @param array $line
     * @return boolean|array
     */
    public function parseImages(array $line){
        $images = [];

        if(!key_exists('images', $line)){
            $line['images'] = [];
            return $line;
        }
        
        $temporary = str_replace('"', '', $line['images']);

        if($temporary == ''){
            $line['images'] = [];
            return $line;
        }
        
        $temporary = explode(';', $temporary);
        
        if(empty($temporary)){
            return false;
        }
        
        foreach($temporary as $item){
            
            $start = strpos($item, ':');
            $field = substr($item, 0, $start);
            $imageData = explode(',',substr($item, $start+1, strlen($item)));              
            $images[$field] = $imageData;
        }
        
        if(empty($images)){
            return false;
        }
        
        $line['images'] = $images;
        return $line;
    }

    /**
     * 
     * @param array $line
     * @return boolean|array
     */
    public function parseTerms(array $line){
        $terms = [];
        
        if(!key_exists('terms', $line)){
            return false;
        }
        
        $temporary = $line['terms'];//str_replace('"', '', $line['terms']);
        if($temporary == ''){
            return false;
        }
        
        $temporary = explode(';', $temporary);
        
        if(empty($temporary)){
            return false;
        }
        
        foreach($temporary as $item){
            $vocabulary = trim(substr ( $item , 0 , strpos ( $item , ":" ) ));
            $term = trim(substr ( $item , strlen($vocabulary)+1 ));

            if($vocabulary){
                $terms[$vocabulary][$term] = true;
            }
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
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_STR
        ];
    }
    public static function productFields(){
        return [
                    'sku',
                    'group',
                    'price',
                    'model',
                    'title',
                    'description',
                    'features',
                    'short',
                    'reindex',
                    'crc32',
                    'publish',
                    'user_id',
                    'source_id',
                    'data'
               ];
    }
    public static function termFieldTypes(){
        return [
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_STR
        ];
    }
    public static function termFields(){
        return [
                   'term_id',
                   'entity_id',
                   'vocabulary_id',
                   'field'
               ];
    }
    public static function importImagesFields(){
        return [
                    'entity_id',
                    'field',
                    'model',
                    'name',
                    'path',
                    'size',
                    'mimetype',
                    'delta',
               ];
    }
    public static function importImagesFieldTypes(){
        return [
            \PDO::PARAM_INT,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_INT,
            \PDO::PARAM_STR,
            \PDO::PARAM_INT,
        ];
    }
    
}