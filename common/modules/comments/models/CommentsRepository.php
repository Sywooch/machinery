<?php

namespace common\modules\comments\models;

use common\helpers\ModelHelper;
use dektrium\user\models\Profile;
use dektrium\user\models\User;
use frontend\modules\rating\models\Rating;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;


class CommentsRepository extends Model
{

    const ORDER = SORT_DESC;

    const PAGE_SIZE = 100;

    /**
     * @param null $thread
     * @return mixed
     */
    public function getMaxThread($thread = null)
    {
        if ($thread) {
            $thread .= '.';
        }
        return (new \yii\db\Query())
            ->from(Comments::tableName())
            ->filterWhere(['like', 'thread', $thread])
            ->max('thread');
    }

    /**
     *
     * @param array $params
     * @return array
     */
    public function getCommentIds(array $params)
    {
        return (new \yii\db\Query())
            ->select(['id'])
            ->from(Comments::tableName())
            ->where($params)
            ->column();
    }


    /**
     * @param ActiveRecord $entity
     * @return ActiveDataProvider
     */
    public function getCommentsList(ActiveRecord $entity)
    {

        $query = (new \yii\db\Query())
            ->select([
                'comments.id',
                'comments.parent_id',
                'comments.user_id',
                'comments.comment',
                'comments.created_at',
                'comments.name',
                'user.username',
                'profile.name as profilename',
                'SUBSTRING(comments.thread, 0, 3) AS thread1',
                'thread'
            ])
            ->from(Comments::tableName())
            ->leftJoin(User::tableName() . ' as user', '"user".id = "comments".user_id')
            ->leftJoin(Profile::tableName() . ' as profile', '"profile".user_id = "comments".user_id')
            ->where([
                'comments.entity_id' => $entity->id,
                'comments.model' => StringHelper::basename(get_class($entity))
            ]);

        $query->orderBy([
            'thread1' => SORT_DESC,
            'thread' => SORT_ASC
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ]
        ]);

        return $dataProvider;
    }

}
