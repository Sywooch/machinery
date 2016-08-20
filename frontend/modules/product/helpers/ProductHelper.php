<?php

namespace frontend\modules\product\helpers;

use yii\helpers\Html;
use yii\base\InvalidParamException;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use frontend\modules\product\models\GroupCharacteristics;

class ProductHelper {
    
    /**
     * 
     * @param object $product
     * @return []
     */
    public static function getBreadcrumb($entity){
        $breadcrumb = [];
        foreach($entity->catalog as $taxonomyItem){
            $breadcrumb[] = ['label' => Html::encode($taxonomyItem->name), 'url' => $taxonomyItem->transliteration];
        }
        $breadcrumb[] = Html::encode($entity->title);
        return $breadcrumb;
    }
    
    
    public static function getCharacteristicsByTerms(array $terms){
        $groupCharacteristics = GroupCharacteristics::find()->all();
        $grouped = [];
        $vocabularies = TaxonomyVocabulary::find()->indexBy('id')->where([
            'id' => array_column($terms, 'vid')
        ])->all();
        
        foreach ($terms as $term){
            foreach($groupCharacteristics as $item){
                if(in_array($term->vid, $item->vocabularies)){
                    if(!isset($grouped[$item->id])){
                        $grouped[$item->id] = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'items' => []
                        ];
                    }
                   $grouped[$item->id]['items'][] = [
                       'name' => $vocabularies[$term->vid]->name,
                       'value' => $term->name
                   ]; 
                }
            } 
        }
       return $grouped;
    }
}