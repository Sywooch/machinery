<?php

namespace common\modules\address\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\address\exceptions\InvalidGeoCoderException;
use common\modules\address\helpers\AddressHelper;
use common\modules\address\services\GeoAddress;
use yii\helpers\ArrayHelper;

class AddressBehavior extends Behavior
{
    /**
     * @var string
     */
    public $geoCoder;

    /**
     * @var array
     */
    public $addresses = [];

    /**
     * @var GeoAddress
     */
    private $geoAddress;


    /**
     * @throws InvalidGeoCoderException
     */
    public function init()
    {
        if (!$this->geoCoder) {
            throw new InvalidGeoCoderException();
        }

        $this->geoAddress = new GeoAddress(new $this->geoCoder());

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'afterSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'afterSave',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        $attributes = AddressHelper::getAddressAttributes($this->owner);

        foreach ($attributes as $attribute => $rule) {

            if (!$this->owner->{$attribute} || !is_string($this->owner->{$attribute})) {
                continue;
            }

            $this->addresses = $this->geoAddress->createAddresses($this->owner->{$attribute});

            if (empty($this->addresses)) {
                $this->owner->addError($attribute, 'Invalid address.');
            } else {
                $this->owner->{$attribute} = ArrayHelper::getColumn($this->addresses, 'id');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave()
    {
        $addressAttributes = AddressHelper::getAddressAttributes($this->owner);
        $modelAttributes = $this->owner->attributes();
        foreach ($addressAttributes as $attribute => $rule) {
            if (empty($this->owner->attribute) || !in_array($attribute, $modelAttributes)) {
                continue;
            }
            // TODO: Saving to "via" table
        }
    }


}