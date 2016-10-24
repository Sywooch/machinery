<?php

namespace common\modules\taxonomy\helpers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\components\TermValidator;
use common\modules\taxonomy\models\TaxonomyItems;

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
     * @param array $terms
     * @return []
     */
    public static function order(array $terms){
        $tree = self::treeMap($terms);
        return array_reverse(self::tree2Flat(reset($tree)));
    }
    
    /**
     * 
     * @param TaxonomyItems $tree
     * @param array $terms
     * @return TaxonomyItems
     */
    private static function tree2Flat(TaxonomyItems $tree, &$terms = []){
        if(!empty($tree->childrens)){
            foreach($tree->childrens as $children){
               self::tree2Flat($children, $terms); 
            }
        }
        $tree->childrens = [];
        $terms[] = $tree;
        return $terms;
    }

    


    /**
     * 
     * @param array $dataset
     * @param string $childKey
     * @return array
     */
    private static function treeMap(array $dataset, $childKey = 'children') {
        $dataset = ArrayHelper::index($dataset, 'id');
        
        $tree = [];
        foreach ($dataset as $id => &$node) {
            if (isset($node->pid)) {
                if (!$node->pid) {
                    $node->pid = 0;
                    $tree[$node->id] = &$node;
                }else{
                    $dataset[$node->pid]->childrens[] = &$node;
                }
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
        foreach ($tree as $index => $item) {
            if (!empty($item->childrens) && $curDepth + 1 > $maxDepth){
                $item->childrens = [];
            }elseif (!empty($item->childrens)){
                $item->childrens = self::treeDepth($item->childrens, $maxDepth, $curDepth + 1);
            }
            $tree[$index] = $item;
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
        
        foreach ($tree as $index => $item) {
            if ($item->id == $parent){
                return [$index => $item];
            }elseif (isset($item->childrens)){
                $tree = self::treeParent($item->childrens, $parent);
            }
                
        }
        return $tree;
    }
    
    /**
     * 
     * @param array $terms
     * @return int
     */
    public function countChildren(TaxonomyItems $tree){
        $count = count($tree->childrens);
        if($count){
            foreach($tree->childrens as $children){
               $count += self::countChildren($children); 
            }
        }
        
        return $count;
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @return TaxonomyItems
     */
    public function lastChildren(TaxonomyItems $term){
        
        if(empty($term->childrens)){
            return $term;
        }

        foreach($term->childrens as $children){
           return self::lastChildren($children); 
        }    
    }

    /**
     * 
     * @param [] $tree
     * @param ineger $parent
     * @param integer $weight
     * @return []
     */
    public static function nes2Flat($tree, $parent = 0, $weight = 0 ) {
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
    
    /**
     * 
     * @param [] $terms
     * @return JSON
     */
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
