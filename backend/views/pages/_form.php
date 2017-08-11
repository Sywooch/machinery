<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test')->dropDownList(\yii\helpers\ArrayHelper::map($terms1,'id','name'),[ 'prompt'=>'- Select -']) ?>
    <?= $form->field($model, 'test2')->dropDownList(\yii\helpers\ArrayHelper::map($terms2,'id','name'),[ 'prompt'=>'- Select -', 'multiple' => 'multiple']) ?>

    <?= $form->field($model, 'body')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 600,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
