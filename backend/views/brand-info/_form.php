<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\modules\file\helpers\FileHelper;
use common\modules\file\Asset as FileAsset;
use common\modules\taxonomy\widgets\field\TaxonomyField;

/* @var $this yii\web\View */
/* @var $model backend\models\BrandInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-info-form">

    <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'brand')->widget(TaxonomyField::classname()); ?>
    
    <?= $form->field($model, 'photo[]')->widget(FileInput::classname(),FileHelper::FileInputConfig($model, 'photo')); ?>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
