<?php

namespace frontend\modules\product\helpers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
        $url = '';
        foreach($entity->catalog as $taxonomyItem){
            $url .= '/'.$taxonomyItem->transliteration;
            $breadcrumb[] = ['label' => Html::encode($taxonomyItem->name), 'url' => $url];
        }
        $breadcrumb[] = Html::encode($entity->title);
        return $breadcrumb;
    }
    
    public static function getParametersTitle($product){
        $terms = ArrayHelper::index($product->terms, 'vid');
        $title = [];
        $title[] = $product->title;
        $title[] = ArrayHelper::getValue($terms, '6.name'); // color
        $title = array_filter($title);
        return implode(' ', $title);
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