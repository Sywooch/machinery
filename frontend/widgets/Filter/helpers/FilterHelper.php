<?php

namespace frontend\widgets\Filter\helpers;

use common\modules\taxonomy\helpers\TaxonomyHelper;

class FilterHelper
{

    /**
     * @param array $terms
     * @param array $index
     * @param string $field
     * @return array
     */
    public static function getItems(array $terms, array $index, string $field)
    {
        $return = [];

        foreach ($terms as $item){
            if($field != $index[$item->id]['field'] || $item->pid){
                continue;
            }
            $tmp = $item->getAttributes();
            $tmp['count'] = $index[$item->id];
            $return[] = $tmp;
        }
        return $return;
    }

    /**
     * @param array $terms
     * @param array $index
     * @return array
     */
    public static function getCategories(array $terms, array $index){

        $return = [];
        $tree = TaxonomyHelper::tree($terms);

        foreach ($tree as $level0){
            if($level0->vid != 2){
                continue;
            }
            if(isset($level0->childrens)){
                foreach ($level0->childrens as $level1){

                    $tmp = $level1->getAttributes();
                    $tmp['count'] = $index[$level1->id];
                    $return[] = $tmp;

                    if(isset($level1->childrens)){
                        foreach ($level1->childrens as $level2){

                            $tmp = $level2->getAttributes();
                            $tmp['count'] = $index[$level2->id];
                            $return[] = $tmp;

                        }
                    }
                }
            }

        }

        return $return;
    }


}