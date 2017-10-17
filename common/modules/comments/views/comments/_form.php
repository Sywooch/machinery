<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<style>
    #ajax-comment-form {
        padding: 30px;
    }

    #ajax-comment-form label {
        margin-right: 40px;
    }
</style>

<?php

$form = ActiveForm::begin([
    'id' => 'ajax-comment-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true
])
?>

<div class="comment-user-info">

    <?php if (Yii::$app->user->isGuest): ?>
        <?= $form->field($model, 'name', ['template' => '{input}{error}'])->textInput(['placeholder' => $model->getAttributeLabel('name')]); ?>

        <?= $form->field($model, 'feed_back', ['template' => '{input}{error}'])->textInput(['placeholder' => $model->getAttributeLabel('feed_back')]); ?>
    <?php else: ?>
        <?= Yii::$app->user->identity->profile->name ? Html::a(Html::encode(Yii::$app->user->identity->profile->name), '/user/' . Yii::$app->user->id) : Html::a(Html::encode(Yii::$app->user->identityusername), '/user/' . Yii::$app->user->id); ?>
    <?php endif; ?>
</div>

<?= $form->field($model, 'comment', ['template' => '{input}{error}'])->textarea(['rows' => 8, 'placeholder' => $model->getAttributeLabel('comment')]); ?>

<?php if (Yii::$app->user->isGuest): ?>
    <?php
    echo $form->field($model, 'verifyCode', ['template' => '{input}{error}'])->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-4">{input}</div><div class="col-lg-3">{image}</div></div>',
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

