<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\file\helpers\FileHelper;
use common\modules\file\Asset as FileAsset;
use kartik\file\FileInput;
use vova07\imperavi\Widget;
use yii\helpers\Url;

FileAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'image[]')->widget(FileInput::classname(),FileHelper::FileInputConfig($model, 'image')); ?>
    
    <?= $form->field($model, 'short')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'body')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 600,
                'imageUpload' => Url::to(['site/image-upload']),
                'imageManagerJson' => Url::to(['site/images-get']),
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
