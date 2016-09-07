<?php

use yii\helpers\Html;
use frontend\modules\comments\helpers\CommentsHelper;
?>

<div class="level level-<?= substr_count($comment['thread'], '.'); ?> ">  
    <?php if($comment['user_id']):?>
	<?php if ($comment['file_id']): ?>
            <?=Html::a(Html::img('/'.StyleHelper::getPreviewUrl($avatars[$comment['file_id']], '100x100'), ['width' => '48px', 'class' => 'img-circle']),['/user/' . $comment['user_id']]);?>
        <?php else:?>
            <?=Html::a(Html::img('/files/no-avatar.jpg', ['width' => '48px', 'class' => 'img-circle']),['/user/' . $comment['user_id']]);?>
        <?php endif;?>
    <?php else:?>
        <?php if ($comment['file_id']): ?>
            <?=Html::img('/'.StyleHelper::getPreviewUrl($avatars[$comment['file_id']], '100x100'), ['width' => '48px', 'class' => 'img-circle']);?>
        <?php else:?>
            <?=Html::img('/files/no-avatar.jpg', ['width' => '48px', 'class' => 'img-circle']);?>
        <?php endif;?>
    <?php endif;?>
    <div class="comment-body">
        <div class="comments-author">
            <?php if($comment['name']):?>
                <?=Html::encode($comment['name']);?>
            <?php elseif($comment['profilename']):?>
                <?=Html::a(Html::encode($comment['profilename']), ['/user/' . $comment['user_id']])?>
            <?php elseif($comment['username']):?>
                <?=Html::a(Html::encode($comment['username']), ['/user/' . $comment['user_id']])?>
            <?php else:?>
                НЛО
            <?php endif;?>
            <span class="comments-created">  <?= Yii::$app->formatter->asDatetime($comment['created_at']); ?> </span>
        </div>
        <div class="comment">
                <?= Html::encode($comment['comment']); ?>
        </div>
        <div class="comment-control">
            <?php if (isset($maxThread) && substr_count($comment['thread'], '.') < $maxThread): ?>
                <?=Html::a('Ответить', ['/comments/default/answer', 'id' => $comment['id'], 'token' => CommentsHelper::getToken($comment)], ['class' => 'ajax-comment-link answer']);?>
            <?php endif; ?>
            <?php if (Yii::$app->user->id && $comment['user_id'] == Yii::$app->user->id): ?>
                <?=Html::a('Редактировать', ['/comments/default/update', 'id' => $comment['id']], ['class' => 'ajax-comment-link update']);?>
            <?php endif; ?>
        </div>
    </div>
</div>