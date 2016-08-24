<?php

namespace frontend\modules\comments\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use frontend\modules\comments\models\CommentsRepository;
use frontend\modules\comments\helpers\CommentsHelper;
use frontend\modules\comments\models\Comments;
use yii\base\Event;

class CommentsBehavior extends Behavior
{
    const COMMENTS_UPDATE = 'comments-update';
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSaveComment',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSaveComment'
        ];
    }
    
    /** @inheritdoc */
    public function beforeSaveComment($insert) {
        if ($insert && !$this->owner->id) {
            if ($this->owner->parent_id == 0) {
                $maxThread = CommentsRepository::getMaxThread();
                $thread = CommentsHelper::int2vancode(CommentsHelper::vancode2int(CommentsHelper::getFirstThreadSegment($maxThread)) + 1) . '/';
            } else {
                $parent = Comments::findOne($this->owner->parent_id);
                $thread = (string) rtrim((string) $parent->owner->thread, '/'); 
                $maxThread = CommentsRepository::getMaxThread($thread); 
                if ($maxThread == '') {
                    $thread = $thread . '.' . CommentsHelper::int2vancode(0) . '/';
                } else {
                    $thread = $thread . '.' . CommentsHelper::int2vancode(CommentsHelper::vancode2int(CommentsHelper::getLastThreadSegment($thread, $maxThread)) + 1) . '/';
                }
            }
            $this->owner->created_at = time();
            $this->owner->thread = $thread;
            $this->owner->user_id = \Yii::$app->user->id;
            $this->owner->ip = $_SERVER['REMOTE_ADDR'];
        }
        
        Yii::$app->event->trigger(self::COMMENTS_UPDATE, new Event(['sender' => $this->owner]));
    }
}

?>