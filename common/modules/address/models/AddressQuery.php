<?php

namespace common\modules\address\models;

use yii\db\ActiveQuery;
use yii\db\Expression;
use common\modules\realty\helpers\Coordinates;

class AddressQuery extends ActiveQuery
{

    /**
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
    public function point(float $latitude, float $longitude)
    {
        return $this->andWhere([
            'point' => new Expression("ST_MakePoint($latitude, $longitude)")
        ]);
    }

    /**
     * @param array $coordinates
     * @return mixed
     */
    public function polygon(array $coordinates)
    {
        return $this
            ->andWhere(new Expression('ST_CoveredBy(point,ST_GeogFromText(\'SRID=4326;POLYGON((' . Coordinates::coordinatesToString($coordinates) . '))\'))'));
    }

    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type)
    {
        return $this
            ->andWhere(['type' => $type]);
    }

    /**
     * @param string $address
     * @return $this
     */
    public function trigram(string $address)
    {
        return $this
            ->andWhere(new Expression('name % :address', ['address' => $address]));
    }
}