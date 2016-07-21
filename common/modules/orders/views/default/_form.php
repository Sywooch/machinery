<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\modules\orders\Asset;
use common\modules\orders\widgets\delivery\Delivery;

Asset::register($this);

?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(['id' => 'orders-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment')->dropDownList([ 'Наличный' => 'Наличный', 'Безналичный' => 'Безналичный', 'При получении' => 'При получении', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'delivery')->widget(Delivery::classname()) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
