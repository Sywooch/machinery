<?php

use common\modules\comments\helpers\CommentsHelper;
use yii\helpers\Html;

?>


<div class="level level-<?= substr_count($comment->thread, '.'); ?> ">

    <div class="comment-body">
        <div class="clearfix">
            <div class="comments-created"><?=Yii::$app->formatter->asDatetime($comment->created_at)?></div>
            <div class="comments-author">
                <?php if ($comment->name): ?>
                    <?= Html::encode($comment->name); ?>
                <?php elseif ($comment->user && $comment->user->profile->name): ?>
                    <?= Html::a(Html::encode($comment->user->profile->name), ['/user/' . $comment->user->id]) ?>
                <?php elseif ($comment->user && $comment->user->username): ?>
                    <?= Html::a(Html::encode($comment->user->username), ['/user/' . $comment->user->id]) ?>
                <?php else: ?>
                    НЛО
                <?php endif; ?>

            </div>
        </div>
        <div class="comment">
            <?= Html::encode($comment->comment); ?>
        </div>
        <div class="comment-control">
            <?php if (isset($maxThread) && substr_count($comment->thread, '.') < $maxThread): ?>
                <?= Html::a('Ответить', ['/comments/comments/answer', 'id' => $comment->id, 'token' => CommentsHelper::getToken($comment->id)], ['class' => 'ajax-comment-link answer']); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->id && $comment->user_id == Yii::$app->user->id): ?>
                <?= Html::a('Редактировать', ['/comments/comments/update', 'id' => $comment->id], ['class' => 'ajax-comment-link update']); ?>
            <?php endif; ?>
        </div>
    </div>
</div>


