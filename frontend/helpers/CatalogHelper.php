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

    public static function tree2flat($tree,$level=0, $prefix='- ')
    {
        $out = [];
        if (!is_array($tree)) {
            return [];
        }

        foreach ($tree as $item){
            $_data = $item->attributes;
            $_data['level'] = $level;
            $out[$item['id']] = $_data;
            if($item['childrens']){
                $t = self::tree2flat($item['childrens'], $level+1);
                $out += $t;
            }
        }
        return self::termsAsLevel($out, $prefix);

    }

    public static function termsAsLevel($termins, $prefix){
        $_lang = \Yii::$app->language;
        foreach ($termins as $key =>$item){
            $_title = (isset($item['data']['translations'][$_lang]) && !!$item['data']['translations'][$_lang]) ? $item['data']['translations'][$_lang] : $item['name'];
            $termins[$key]['title'] = str_repeat($prefix, $item['level']) . $_title;
        }
        return $termins;
    }

    public static function optionsForSelect($array){
        if(!is_array($array)) return [];
        $out = [];
        foreach ($array as $k => $item){
            $out[$k] = [
                'class' => 'level-' . $item['level']
            ];
        }
        return $out;
    }

    public static function childrensTree($terms, $id){
        $out = [];
        if($terms){
            foreach ($terms as $term){
                if($term['id'] != $id){
                    $out[] = $term;
                }
            }
        }
        return $out;
    }


}