<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\taxonomy\models\TaxonomyVocabulary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="taxonomy-vocabulary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'prefix')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'transliteration')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'weight')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
