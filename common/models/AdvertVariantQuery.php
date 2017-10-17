<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AdvertVariant]].
 *
 * @see AdvertVariant
 */
class AdvertVariantQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdvertVariant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdvertVariant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
