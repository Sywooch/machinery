<?php

namespace common\modules\address\services\geo;


abstract class GeoCoderAbstract implements GeoCoderInterface
{
    /**
     * @var GeoObject
     */
    protected $_geoObject;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->_geoObject = new GeoObject();
    }

}