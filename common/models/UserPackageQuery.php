<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserPackage]].
 *
 * @see UserPackage
 */
class UserPackageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserPackage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserPackage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
