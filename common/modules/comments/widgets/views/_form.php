<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php
$form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => \yii\helpers\Url::to(['/comments/comments/new'])
])
?>

<div class="comment-user-info">

    <?= $form->field($model, 'entity_id', ['template' => '{input}{error}'])->hiddenInput(); ?>
    <?= $form->field($model, 'model', ['template' => '{input}{error}'])->hiddenInput(); ?>

    <?php if (Yii::$app->user->isGuest): ?>
        <?= $form->field($model, 'name', ['template' => '{input}{error}'])->textInput(['placeholder' => $model->getAttributeLabel('name')]); ?>
        <?= $form->field($model, 'feed_back', ['template' => '{input}{error}'])->textInput(['placeholder' => $model->getAttributeLabel('feed_back')]); ?>
    <?php else: ?>
        <?= Yii::$app->user->identity->profile->name ? Html::a(Html::encode(Yii::$app->user->identity->profile->name), '/user/' . Yii::$app->user->id) : Html::a(Html::encode(Yii::$app->user->identity->username), '/user/' . Yii::$app->user->id); ?>
    <?php endif; ?>
</div>



<?= $form->field($model, 'comment', ['template' => '{input}{error}'])->textarea(['rows' => 8, 'placeholder' => $model->getAttributeLabel('comment')]); ?>



<?php if (Yii::$app->user->isGuest): ?>
    <?= $form->field($model, 'verifyCode', ['template' => '{input}{error}'])->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">{input}</div><div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">{image}</div></div>',
        'captchaAction' => '/site/captcha',
        'options' => [
            'class' => 'form-control',
            'placeholder' => $model->getAttributeLabel('verifyCode'),
        ]
    ]);
    ?>
<?php endif; ?>

<?= Html::submitButton('Отправить', ['class' => 'btn btn-default btn-block']) ?>

<?php ActiveForm::end(); ?>
