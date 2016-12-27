<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use common\modules\store\PromoAsset;

PromoAsset::register($this);

?>

 <?php $form = ActiveForm::begin(['id'=>'promo-code']); ?>

    <?= $form->field($model, 'code', [])->widget(MaskedInput::className(), [
            'mask' => '(9|A){3}-(9|A){3}-(9|A){3}-(9|A){3}'
        ])->textInput([ 'placeholder' => 'AAA-AAA-AAA-AAA']);
    ?>
    <?= Html::submitButton('Активировать', ['class' => 'btn btn-default', 'disabled' => 'disabled' ]) ?>
<?php ActiveForm::end(); ?>


