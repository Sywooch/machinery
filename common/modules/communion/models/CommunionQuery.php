<?php

namespace common\modules\communion\models;

/**
 * This is the ActiveQuery class for [[Communion]].
 *
 * @see Communion
 */
class CommunionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Communion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Communion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
