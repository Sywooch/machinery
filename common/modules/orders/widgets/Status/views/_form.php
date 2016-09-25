<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="cart-orders-statuses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($statusModel, 'to')->dropDownList($statuses); ?>

    <?= $form->field($statusModel, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
