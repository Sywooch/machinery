<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\datetime\DateTimePicker;
use common\modules\orders\PromoAsset;

PromoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\modules\product\models\PromoCodes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-codes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code', [])->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '(9|A){3}-(9|A){3}-(9|A){3}-(9|A){3}'
        ])->textInput([ 'placeholder' => 'AAA-AAA-AAA-AAA']);
    ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'time')->widget(DateTimePicker::classname(), [
	'options' => ['placeholder' => 'Enter event time ...'],
	'pluginOptions' => [
		'autoclose' => true
	]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
