<?php

namespace common\modules\favorites\models;

use yii;
use yii\db\Query;

class FavoritesCategoryRepository
{
    /**
     * @param \common\modules\favorites\models\Favorites $favorite
     * @param int $categoryId
     * @return mixed
     */
    public function check(Favorites $favorite, int $categoryId)
    {
        return (new Query())
            ->select(['id'])
            ->from(FavoritesCategory::tableName())
            ->where([
                'favorite_id' => $favorite->id,
                'category_id' => $categoryId
            ])
            ->scalar();
    }

    /**
     * @param int $id
     * @return int
     * @throws \yii\db\Exception
     */
    public function remove(int $id)
    {
        return Yii::$app->db
            ->createCommand()
            ->delete(FavoritesCategory::tableName(), 'id = ' . $id)
            ->execute();
    }

    /**
     * @param \common\modules\favorites\models\Favorites $favorite
     * @param int $categoryId
     * @return int
     * @throws \yii\db\Exception
     */
    public function add(Favorites $favorite, int $categoryId)
    {
        return Yii::$app->db->createCommand()->insert(FavoritesCategory::tableName(), [
            'favorite_id' => $favorite->id,
            'category_id' => $categoryId
        ])->execute();
    }

}
