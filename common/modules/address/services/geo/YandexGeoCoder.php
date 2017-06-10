<?php

namespace common\modules\address\services\geo;

use yii\helpers\ArrayHelper;

class YandexGeoCoder extends GeoCoderAbstract
{
    const GEO_URL = 'http://geocode-maps.yandex.ru/1.x/?geocode=[data]&format=json&sco=latlong&results=10';

    private $data;

    /**
     * @inheritdoc
     */
    public function query($string)
    {
        $this->data = json_decode(
            file_get_contents(str_replace('[data]', $string, self::GEO_URL)
            ));

        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function find(string $string, $cache = true)
    {
        $this->data = $this->populate($this->query($string));

        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function getCount()
    {
        return count($this->data);
    }

    /**
     * @param mixed $data
     * @return array
     */
    private function populate($data)
    {

        $collection = [];
        foreach (ArrayHelper::getValue($data, 'response.GeoObjectCollection.featureMember', []) as $item) {
            $object = clone $this->_geoObject;
            $object->data = $item->GeoObject;
            $object->type = $item->GeoObject->metaDataProperty->GeocoderMetaData->kind;
            $object->name = $item->GeoObject->name;
            $object->address = $item->GeoObject->metaDataProperty->GeocoderMetaData->text;
            $object->description = isset($item->GeoObject->description) ? $item->GeoObject->description : '';
            $object->components = $item->GeoObject->metaDataProperty->GeocoderMetaData->Address->Components;
            list($object->longitude, $object->latitude) = explode(' ', $item->GeoObject->Point->pos);
            $collection[] = $object;
        }

        return $collection;
    }

}