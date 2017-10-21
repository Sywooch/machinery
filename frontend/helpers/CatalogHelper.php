<?php

namespace frontend\helpers;

class CatalogHelper
{
    /**
     * @param array $terms
     * @param $term
     * @return mixed
     */
    public static function getRootCategory(array $terms, $term)
    {
        if(!$term->pid){
            return $term;
        }
        foreach ($terms as $item){
            if($term->pid == $item->id){
                return self::getRootCategory($terms, $item);
            }
        }
    }



}