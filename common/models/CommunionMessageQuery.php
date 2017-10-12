<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CommunionMessage]].
 *
 * @see CommunionMessage
 */
class CommunionMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CommunionMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CommunionMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
