<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OrderPackage]].
 *
 * @see OrderPackage
 */
class OrderPackageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OrderPackage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrderPackage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
