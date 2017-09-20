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
    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'term')->textInput(['type'=>'number']) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'term_advert')->textInput(['type'=>'number']) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'quantity')->textInput(['type'=>'number']) ?></div>
    </div>

<!--    --><?php //dd($model->optionsPack, 0); ?>
    <?= $form->field($model, 'optionsPack')->checkboxList(
        ArrayHelper::map(
            TarifOptions::find()
                ->where(['status'=>true])
                ->orderBy(['weight'=>'asc'])
                ->all(),
            'id', 'name'),
        [
            'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                $check = $checked ? ' checked="checked"' : '';
                return "<div><input type=\"checkbox\" class=\"fm-chekbox\" $check name=\"$name\" value=\"$value\" id=\"$name$value\"><label for=\"$name$value\">$label</label></div>";
            }]);
         ?>
    <?= $form->field($model, 'weight')->textInput()->label('Позиция в списке') ?>
    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
