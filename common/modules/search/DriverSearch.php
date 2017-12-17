<?php
/**
 * Created by PhpStorm.
 * User: al
 * Date: 26.07.2017
 * Time: 12:13
 */

namespace common\modules\search;


interface DriverSearch
{
    public function getIndex() : DriverIndex;

    public function search(string $string);
}