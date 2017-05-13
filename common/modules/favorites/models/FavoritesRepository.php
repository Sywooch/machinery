<?php

namespace common\modules\favorites\models;

use yii;
use yii\db\Query;

class FavoritesRepository
{

    /**
     * @param int $entityId
     * @param string $model
     * @param int|null $userId
     * @return false|null|string
     */
    public function check(int $entityId, string $model, int $userId = null)
    {
        return (new Query())
            ->select(['id'])
            ->from(Favorites::tableName())
            ->where([
                'entity_id' => $entityId,
                'model' => $model
            ])
            ->andFilterWhere([
                'user_id' => $userId
            ])
            ->scalar();
    }

    /**
     * @param int $id
     * @return int
     */
    public function remove(int $id)
    {
        return Yii::$app->db
            ->createCommand()
            ->delete(Favorites::tableName(), 'id = ' . $id)
            ->execute();
    }

    /**
     * @param int $userId
     * @param int $entityId
     * @param string $model
     * @return int
     * @throws yii\db\Exception
     */
    public function add(int $userId, int $entityId, string $model)
    {
        return Yii::$app->db->createCommand()->insert(Favorites::tableName(), [
            'entity_id' => $entityId,
            'model' => $model,
            'user_id' => $userId
        ])->execute();
    }

    /**
     * @param int $userId
     * @return int
     */
    public function count(int $userId)
    {
        return (new Query())
            ->select('COUNT(id)')
            ->from(Favorites::tableName())
            ->where([
                'user_id' => $userId,
            ])
            ->count();
    }

    /**
     * @param array $params
     * @return yii\db\ActiveQuery
     */
    public function find(array $params)
    {
        return Favorites::find()
            ->distinct()
            ->leftJoin(FavoritesCategory::tableName() . ' c', 'c.favorite_id = ' . Favorites::tableName() . '.id')
            ->filterWhere($params);
    }

    /**
     * @param int $id
     * @return static
     */
    public function getById(int $id)
    {
        return Favorites::findOne($id);
    }

}
