<?php

namespace common\modules\address\services;

use common\modules\address\services\geo\GeoCoderInterface;
use common\modules\address\models\Address;
use common\modules\address\services\geo\GeoObject;
use common\behaviors\composite\CompositeInterface;
use yii\helpers\ArrayHelper;

class GeoAddress
{
    /**
     * @var string
     */
    private $geoCoder;

    /**
     * @var bool
     */
    private $hasNew = false;


    /**
     * GeoAddress constructor.
     * @param GeoCoderInterface $geoCoder
     */
    public function __construct(GeoCoderInterface $geoCoder)
    {
        $this->geoCoder = $geoCoder;
    }

    /**
     * @param string $address
     * @return array
     */
    public function createAddresses(string $address)
    {
        $models = [];
        $this->hasNew = false;

        foreach ($this->geoCoder->find($address) as $object) {
            $models[] = $this->createdAddress($object);
        }

        if ($this->hasNew) {
            $models = $this->rebuild($models);
        }

        return $models;
    }

    /**
     * @param array $models
     * @return array
     */
    private function rebuild(array $models)
    {
        $ids = ArrayHelper::getColumn($models, 'id');
        $models = $this->composite($models);
        $models = array_pop($models);
        $models->save();
        return Address::findAll($ids);
    }

    /**
     * @param array $models
     * @return array
     */
    public function composite(array $models)
    {
        if (empty($models)) {
            return [];
        }
        for ($i = 0; $i < count($models) - 1; $i++) {
            if ($models[$i + 1] instanceof CompositeInterface) {
                $models[$i + 1]->addChild($models[$i]);
            }
        }
        return $models;
    }

    /**
     * @param GeoObject $object
     * @return Address
     */
    private function createdAddress(GeoObject $object)
    {
        $address = Address::find()
            ->point(
                $object->latitude,
                $object->longitude
            )
            ->one();

        if (!$address) {
            $this->hasNew = true;
            $address = new Address();
            $address->setAttributes((array)$object);
            $address->save();
        }

        return $address;
    }


}