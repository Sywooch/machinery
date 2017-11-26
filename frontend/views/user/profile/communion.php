<?php

use yii\helpers\Html;
use common\modules\communion\models\CommunionMessage;

$this->beginBlock('title_panel');
echo 'Admin panel';
$this->endBlock();

$this->title = Yii::t('app', 'My messages');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-account">
            <?= $this->render('_photo', ['profile' => $profile]) ?>
            <?= $this->render('_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">
                <?= $this->render('_head') ?>
                <div class="container-communion">
                <div class="h2"><?= $model->subject ?></div>
                <div class="list-messages cf">
                    <?php if ($model): ?>
<!--                        --><?php //dd($model) ?>
                        <?php foreach ($model as $item): ?>
                            <div class="communion-item cf <?= Yii::$app->user->id == $item->user_id ? 'mess-my' : 'mess-his' ?>">
                            <div class="h3 subject"><a href="<?= \yii\helpers\Url::to(['/profile/im', 'id'=>$item->id]) ?>"> <?= $item->id ?> <?= $item->subject ?> <?php if(count($item->newMessages)): ?><span class="badge"><?= count($item->newMessages) ?></span></a><?php endif; ?></a></div>
                                <div class="publish-mess">
<!--                                    --><?php //dd($item->user) ?>
                                    <div class="author"><?= $item->user->username ??  Yii::t('app', 'Unknown author') ?></div>
                                    <div class="date"><?= Yii::$app->formatter->asDatetime($item->create_at, 'j.M.Y H:i:s') ?></div>
                                </div>
                                <div class="buttons">
                                    <a href="<?= \yii\helpers\Url::to(['profile/communion']) ?>" class="link-messages"><i class="fa fa-list" aria-hidden="true"></i></a>
                                    <a href="<?= \yii\helpers\Url::to(['profile/communion-delete', 'id'=>$item->id]) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <a href="#"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div> <!-- .list-messages -->
            </div>

            </div>
        </div>
    </div>
</div>