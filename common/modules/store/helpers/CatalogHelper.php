<?php

namespace common\modules\store\helpers;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use common\helpers\ModelHelper;

class CatalogHelper {
    
    /**
     * 
     * @param object $model
     * @return int
     */
    public function getCatalogIdByModel($model){
        return array_search(get_class($model), \Yii::$app->params['catalog']['models']);
    }
 
    /**
     * 
     * @param array $params
     * @param array $param
     * @return array
     */
    public static function merge(array $params, array $param){
        foreach($param as $key => $value){
            $params[$key] = $value;
        }
        return $params;
    }
    
    /**
     * 
     * @param array $items
     * @return string
     */
    public static function link(array $items){
        $return = [];
        foreach($items as $item){
            $return[] = $item->transliteration;
        }
        return implode('/', $return);
    }

    /**
     * 
     * @param TaxonomyItems $term
     * @param array $compares
     * @param array $models
     * @return []
     */
    public static function compareModelByTerm(TaxonomyItems $term, array $compares, array $models){
        $data = [];
        
        foreach ($compares as $item){
            if($item->term_id == $term->id){
                $data[$item->entity_id] = $models[$item->model][$item->entity_id];
            }
        } 
        return $data;
    }

    /**
     * 
     * @param array $models
     * @return []
     */
    public static function compareFeatures(array $models){

        foreach ($models as $model){
            $data[$model->id] = $model->feature;
        }
        
        $features = [];
        foreach ($data as $entityId => $items){
            foreach ($items as $title => $item){
                foreach ($item as $feature){
                    $features[$title][$feature->name][$entityId] = $feature->value;
                }
            } 
        }

        return $features;
    }
    
    /**
     * 
     * @param type $product
     * @return type
     */
    public static function getCompareButton($entity, array $ids = []){
        return '<div class="cbx-container chb-compare chb-compare-'.$entity->id.' '.(isset($ids[$entity->id]) ? 'active' : '').'" data-id="'.$entity->id.'" data-model="'.ModelHelper::getModelName($entity).'">'.
                    '<div class="cbx cbx-xs cbx-active" tabindex="1000">'.
                        '<span class="cbx-icon"> '.
                            '<i class="glyphicon glyphicon-ok"></i>'.
                        '</span>'.
                    '</div>'.
                    '<label >'.(isset($ids[$entity->id]) ? 'в сравнении' : 'сравнить').'</label>'.
                '</div>';
    }
    
    /**
     * 
     * @param type $product
     * @return type
     */
    public static function getWishButton($entity, array $ids = []){
        return '<div class="cbx-container chb-wish chb-wish chb-wish-'.$entity->id.' '.(isset($ids[$entity->id]) ? 'active' : '').'" data-id="'.$entity->id.'" data-model="'.ModelHelper::getModelName($entity).'">'.
                    '<div class="cbx cbx-xs cbx-active" tabindex="1000">'.
                        '<span class="cbx-icon"> '.
                            '<i class="glyphicon glyphicon-ok"></i>'.
                        '</span>'.
                    '</div>'.
                    '<label >'.(isset($ids[$entity->id]) ? 'в избранном' : 'в избранное').'</label>'.
                '</div>';
    }
    
    
}