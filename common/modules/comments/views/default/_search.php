<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\comments\models\CommentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'entity_id') ?>

    <?= $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'thread') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'feed_back') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'positive') ?>

    <?php // echo $form->field($model, 'negative') ?>

    <?php // echo $form->field($model, 'admin_comment') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
