<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(['id' => 'delivery-form', ]); ?>
<div class="grey">
    <?=
        $form->field($model, 'address')->textInput();
    ?>
</div>
<?php ActiveForm::end(); ?>  


