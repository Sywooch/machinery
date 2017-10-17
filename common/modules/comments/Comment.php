<?php

namespace common\modules\comments;

use common\modules\comments\helpers\CommentsHelper;
use common\modules\comments\models\Comments;
use common\modules\comments\models\CommentsRepository;
use yii;

class Comment
{
    /**
     * @param Comments $comment
     * @return bool
     */
    public static function save(Comments &$comment)
    {
        $parent = null;

        if($comment->parent_id){
            $parent = Comments::findOne($comment->parent_id);
            $comment->model = $parent->model;
            $comment->entity_id = $parent->entity_id;
        }

        $comment->thread = $comment->thread ?? self::thread($parent);
        $comment->created_at = time();
        $comment->user_id = Yii::$app->user->id;
        $comment->ip = Yii::$app->request->userIP;

        return $comment->save();
    }

    /**
     * @param Comments|null $parent
     * @return string
     */
    public static function thread(Comments $parent = null)
    {
        if ($parent) {
            $thread = (string)rtrim((string)$parent->thread, '/');
            $maxThread = CommentsRepository::getMaxThread($thread);
            if ($maxThread == '') {
                $thread = $thread . '.' . CommentsHelper::int2vancode(0) . '/';
            } else {
                $thread = $thread . '.' . CommentsHelper::int2vancode(CommentsHelper::vancode2int(CommentsHelper::getLastThreadSegment($thread, $maxThread)) + 1) . '/';
            }

            return $thread;
        }

        $maxThread = CommentsRepository::getMaxThread();
        return CommentsHelper::int2vancode(CommentsHelper::vancode2int(CommentsHelper::getFirstThreadSegment($maxThread)) + 1) . '/';
    }
}