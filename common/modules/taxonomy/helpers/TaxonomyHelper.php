<?php

namespace common\modules\taxonomy\helpers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\components\TermValidator;

class TaxonomyHelper {
    
    const AJAX_SELECT_URL = 'taxonomy/items/terms-ajax';
    /**
     * 
     * @param array $terms
     * @param int $parent
     * @param int $depth
     * @return array
     */
    public static function tree(array $terms, $parent = 0, $depth = NULL) {

        $tree = self::treeMap($terms);

        if ($parent)
            $tree = self::treeParent($tree, $parent);
        if ($depth !== NULL)
            $tree = self::treeDepth($tree, $depth);
        
        return $tree;
    }
    
    /**
     * 
     * @param array $dataset
     * @param string $childKey
     * @return array
     */
    private static function treeMap(array $dataset, $childKey = 'children') {

        $tree = array();
        foreach ($dataset as $id => &$node) {

            if (key_exists('pid',$node)) {
                if (!$node['pid']) {
                    $node['pid'] = 0;
                    $tree[$id] = &$node;
                } else {
                    $dataset[$node['pid']][$childKey][$id] = &$node;
                }
            } else {
                $n = array_shift($node);
                $id = key($n);
                $tree += $n;
                $tree[$id]['pid'] = 0;
            }
        }

        return $tree;
    }
    
    /**
     * 
     * @param array $tree
     * @param int $maxDepth
     * @param int $curDepth
     * @return array
     */
    private function treeDepth(array $tree, $maxDepth, $curDepth = 0) {
        foreach ($tree as $index => $itm) {
            if (isset($itm['children']) && $curDepth + 1 > $maxDepth){
                unset($itm['children']);
            }elseif (isset($itm['children'])){
                $itm['children'] = self::treeDepth($itm['children'], $maxDepth, $curDepth + 1);
            }
            $tree[$index] = $itm;
        }
        return $tree;
    }
    
    /**
     * 
     * @param array $tree
     * @param int $parent
     * @return array
     */
    private function treeParent(array $tree, $parent) {
        
        if (!$parent){
            return $tree;
        }
        
        foreach ($tree as $index => $itm) {
            if ($itm['id'] == $parent){
                return [$index => $itm];
            }elseif (isset($itm['children'])){
                $tree = self::treeParent($itm['children'], $parent);
            }
                
        }
        return $tree;
    }
    
    public function nes2Flat($tree, $parent = 0, $weight = 0 ) {
        $d = [];
        $t = [];

        if (!is_array($tree)){
            return [];
        }
        foreach ($tree as $key => $item) {
                $additionalFields = $item;
                if (!isset($item['children'])) {
                        $weight++;
                        $d[$item['id']] = array_merge(['pid' => $parent, 'weight' => $weight], $additionalFields);
                } else {
                        unset($additionalFields['children']);
                        $weight++;
                        $d[$item['id']] = array_merge(['pid' => $parent, 'weight' => $weight], $additionalFields);
                        $t = self::nes2Flat($item['children'], $item['id'], $weight);
                        $d += $t;
                }
                $weight++;
        }
        return $d;
    }
    
    /**
     * 
     * @param mixed $model
     * @return array
     */
    public static function getTermFields($model){ 
        $fields = [];
        $rules = $model->rules();
        foreach($rules as $rule){
            if($rule[1] == TermValidator::class){
                $fieldsTmp = [];
                if(is_array($rule[0])){
                    $fieldsTmp = $rule[0];
                }else{
                    $fieldsTmp[] = $rule[0];
                }
                
                unset($rule[0]);
                
                foreach($fieldsTmp as $field){
                    $fields[$field] = array_merge([$field], $rule);
                }
            }  
        }
        return $fields;
    }
    
    public static function terms2IndexedArray($terms){
        
       $terms = ArrayHelper::getColumn($terms, function ($element) {
            return [
                'id' => $element->id,
                'name' => $element->name.':'.$element->vocabulary->name
            ]; 
        });
        
        return json_encode(ArrayHelper::map($terms, 'id', 'name'));
    }
    
}
