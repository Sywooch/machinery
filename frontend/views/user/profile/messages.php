<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;

common\modules\communion\Asset::register($this);

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
                    <div class="h2"><?= $model->subject ?> </div>
                    <div class="create-communion"><?= Yii::$app->formatter->asDatetime($model->create_at, 'j.M.Y H:i:s') ?></div>
                    <div class="list-messages cf">
                        <?php if ($model->messages): ?>
                            <div class="messages-inner cf">

                                <?php foreach ($model->messages as $mess): ?>
                                    <div class="mess-item cf <?= Yii::$app->user->id == $mess->user_id ? 'mess-my' : 'mess-his' ?>">
                                        <!--                                --><?php //dd($mess) ?>
                                        <div class="publish-mess">
                                            <div class="author"><?= $mess->user->username ?? Yii::t('app', 'Unknown author') ?></div>
                                            <div class="date"><?= Yii::$app->formatter->asDatetime($mess->create_at, 'j.M.Y H:i:s') ?></div>
                                        </div>
                                        <div class="body"><?= $mess->body ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($mess->user): ?>
                                <?php $form = ActiveForm::begin([
                                    'action' => \yii\helpers\Url::to(['communion/message/create']),
                                    'options' => ['id' => 'communion-message-form', 'class' => 'ajax-message-form'],
                                ]); ?>
                                <?= $form->field($message, 'body')->textarea(['rows' => 4])->label(false) ?>
                                <?= $form->field($message, 'communion_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                                <?= $form->field($message, 'user_to')->hiddenInput(['value' => $model->id])->label(false) ?>
                                <button type="submit"
                                        class="btn btn-success btn-lg"><?= Yii::t('app', 'Send') ?></button>
                                <?php ActiveForm::end(); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div> <!-- .list-messages -->
                </div>
            </div>
        </div>
    </div>
</div>