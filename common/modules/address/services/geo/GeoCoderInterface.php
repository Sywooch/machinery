<?php

namespace common\modules\address\services\geo;


interface GeoCoderInterface
{
    /**
     * @param $string
     * @return mixed
     */
    public function query($string);

    /**
     * @param string $string
     * @param bool $composite
     * @return array
     */
    public function find(string $string, $composite = false);

    /**
     * @return int
     */
    public function getCount();
}