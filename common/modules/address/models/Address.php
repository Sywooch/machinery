<?php

namespace common\modules\address\models;

use common\behaviors\composite\CompositeBehavior;
use Yii;
use common\behaviors\composite\CompositeInterface;
use common\behaviors\composite\CompositeItemInterface;
use yii\db\Expression;

class Address extends AddressBase implements CompositeInterface, CompositeItemInterface
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => CompositeBehavior::class,
            ]
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->point = new Expression("ST_MakePoint($this->latitude, $this->longitude)");
        return parent::beforeValidate();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode([
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ]);
    }


    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }
    

    /**
     * @inheritdoc
     */
    public function bindToObject(CompositeInterface $parent)
    {
        $this->parent_id = $parent->id;
    }

}

