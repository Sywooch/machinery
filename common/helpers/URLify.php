<?php

namespace common\helpers;

use Yii;
use URLify as URLifyBase;

class URLify extends URLifyBase {

    private static $chars;

    public static function url($text, $length = 120, $language = "", $file_name = true, $use_remove_list = true, $lower_case = true, $treat_underscore_as_space = true){
        $text = self::transliterate ($text);
        return parent::filter ($text, $length, $language, $file_name, $use_remove_list, $lower_case, $treat_underscore_as_space);
    }
    
    public static function transliterate ($text) {
	if(!self::$chars){
            \URLify::add_chars(array (',' => '.'));
            self::$chars = true;
        }
        return parent::downcode ($text);
    }

    
}
