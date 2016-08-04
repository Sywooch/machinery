<?php

namespace frontend\modules\comments\models;

use frontend\modules\comments\models\Comments;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use common\modules\file\models\File;
use common\helpers\ModelHelper;
use yii\data\ActiveDataProvider;
use yii\base\Model;

class CommentsRepository extends Model {

    const ORDER = SORT_ASC;
    const PAGE_SIZE = 40;
   

    public function getMaxThread($thread = null){
        return (new \yii\db\Query())
                        ->from(Comments::tableName())
                        ->filterWhere(['like', 'thread', $thread . '.%',])//->createCommand()->getRawSql();
                        ->max('thread');
    }
    
    public function getComment(Comments $model) {
        return (new \yii\db\Query())
                    ->select([
                        'comments.id',
                        'comments.user_id',
                        'comments.comment',
                        'comments.created_at',
                        'comments.name',
                        'user.username',
                        'profile.name as profilename',
                        'file.id as file_id',
                        'thread'
                    ])
                    ->from(Comments::tableName())
                    ->leftJoin(User::tableName().' as user', 'user.id = comments.user_id')
                    ->leftJoin(Profile::tableName().' as profile', 'profile.user_id = comments.user_id')
                    ->leftJoin(File::tableName().' as file', 'file.entity_id = comments.user_id AND file.model="'.ModelHelper::getModelName(Profile::class).'" AND file.field="avatar" AND file.delta = 0')
                    ->where([
                        'comments.id' => $model->id
                    ])->one();
    }
    
    public function getCommentsList(Comments $model) {
        
        
        $query = (new \yii\db\Query())
                    ->select([
                        'comments.id',
                        'comments.user_id',
                        'comments.comment',
                        'comments.created_at',
                        'comments.name',
                        'user.username',
                        'profile.name as profilename',
                        'file.id as file_id',
                        'SUBSTRING(comments.thread, (1), (LENGTH(comments.thread) - 1)) AS thread1',
                        'thread'
                    ])
                    ->from(Comments::tableName())
                    ->leftJoin(User::tableName().' as user', 'user.id = comments.user_id')
                    ->leftJoin(Profile::tableName().' as profile', 'profile.user_id = comments.user_id')
                    ->leftJoin(File::tableName().' as file', 'file.entity_id = comments.user_id AND file.model="'.ModelHelper::getModelName(Profile::class).'" AND file.field="avatar" AND file.delta = 0')
                    ->where([
                        'comments.entity_id' => $model->entity_id,
                        'comments.model' => $model->model  
                    ]);

        if (self::ORDER == SORT_ASC) {
            $query->orderBy([
                'thread1' => SORT_ASC,
            ]);
        } else {
            $query->orderBy([
                'comments.thread' => self::ORDER,
            ]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ]
        ]);

        return $dataProvider;
    }

}