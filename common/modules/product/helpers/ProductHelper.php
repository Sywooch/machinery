<?php

namespace common\modules\product\helpers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\product\models\GroupCharacteristics;

class ProductHelper {
    
    /**
     * 
     * @param object $product
     * @return []
     */
    public static function getBreadcrumb($entity){
        $breadcrumb = [];
        $breadcrumb[] = ['label' => 'Каталог', 'url' => '/catalog'];
        $url = '';
        foreach($entity->catalog as $taxonomyItem){
            $url .= '/'.$taxonomyItem->transliteration;
            $breadcrumb[] = ['label' => Html::encode($taxonomyItem->name), 'url' => $url];
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
                    if(!isset($grouped[$item->name])){
                        $grouped[$item->name] = [];
                    }
                    $grouped[$item->name][] = [
                        'name' => $vocabularies[$term->vid]->name,
                        'value' => $term->name
                    ]; 
                }
            } 
        }
       return $grouped;
    }
    
    public static function getShortFromProduct($model){
        $data = [];
        
    }
}