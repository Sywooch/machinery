<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\TarifOptions;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\TarifPackages */
/* @var $form yii\widgets\ActiveForm */

?>
<!--<pre>--><?php //print_r($model) ?><!--</pre>-->
<div class="tarif-packages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sub_caption')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'term')->textInput() ?>
    <?= $form->field($model, 'options')->checkboxList(
        ArrayHelper::map(
            TarifOptions::find()
                ->where(['status'=>true])
                ->orderBy(['weight'=>'asc'])
                ->all(),
            'id', 'name'));
         ?>
    <?= $form->field($model, 'weight')->textInput()->label('Позиция в списке') ?>
    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
