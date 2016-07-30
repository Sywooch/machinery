<?php

namespace common\helpers;

use Yii;
use URLify as URLifyBase;

class URLify extends URLifyBase {

    private static $chars;

    public static function url($text, $length = 60, $language = "", $file_name = true, $use_remove_list = true, $lower_case = true, $treat_underscore_as_space = true){

        if(!self::$chars){
            \URLify::add_chars(array (',' => '.'));
            self::$chars = true;
        }
        $text = parent::downcode ($text);
        return parent::filter ($text, $length, $language, $file_name, $use_remove_list, $lower_case, $treat_underscore_as_space);
    }

    
}
