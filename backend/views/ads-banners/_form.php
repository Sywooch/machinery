<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\file\widgets\FileInput\FileInputWidget;

?>

<div class="ads-banners-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'banner')->widget(FileInputWidget::class, ['showRemove' => true]); ?>

    <?= $form->field($model, 'region_id')->dropDownList(ArrayHelper::map($regions,'id', 'name')) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($catalog,'id', 'name'),['prompt' => ' -- Select Category --']) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
