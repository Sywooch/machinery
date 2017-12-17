<?php

namespace common\modules\search\drivers\PSG\helpers;

use yii\db\ActiveRecord;
use yii\helpers\Inflector;

class PsgHelper
{

    /**
     * @param ActiveRecord $entity
     * @param array $fields
     * @return string
     */
    public static function data(ActiveRecord $entity, array $fields)
    {
        $data = '';
        foreach ($fields as $field) {
            if (isset($entity->{$field}) && is_string($entity->{$field})) {
                $data .= ' ' . $entity->{$field};
            }
        }
        return self::searchStringProcess($data);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function searchStringProcess(string $string)
    {
        $string = preg_replace("/[^а-яёa-z0-9]/iu", ' ', $string);
        return trim(strtolower(Inflector::transliterate($string)));
    }

    /**
     * @param string $string
     * @param int $len
     * @return array
     */
    public static function keywords(string $string, int $len = 3)
    {
        $data = explode(' ', $string);
        return array_filter($data, function ($var) use ($len) {
            return strlen($var) >= $len;
        });
    }

    /**
     * @param array $words
     * @return array
     */
    public static function insertWordsTemplate(array $words)
    {
        return array_map(function ($item) {
            return [$item];
        }, $words);
    }
}