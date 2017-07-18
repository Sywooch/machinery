<?php

namespace common\helpers;

class BfrStr
{
    /**
     *  Для обрезки строки по целому слову
     */
    public static function substr($str, $length){
        $pos = $length-9;
        if(mb_strlen($str, 'utf-8') > $length){
            $pos = (mb_substr($str, $pos, 1, 'utf-8') === ' ') ? $pos : $pos;
            $key = mb_strpos($str, ' ', $pos, 'utf-8');
            if($key===false){
                return $str;
            }
            echo mb_substr($str, 0, $key, 'utf-8') . '...';
        } else {
            return $str;
        }
    }
}