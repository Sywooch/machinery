<?php

use yii\widgets\ActiveForm;

\common\modules\subscribe\Asset::register($this);
?>

<h3 class="newsletter-title"><?= Yii::t('app','Newsletter'); ?></h3>
<div class="newsletter-form">
<?php $form = ActiveForm::begin([
    'action' => \yii\helpers\Url::to(['subscribe/default/create']),
    'method' => 'post',
    'options' => [ 'id' => 'subscribe-form', 'data-pjax'=>true],
]);?>
    <?= $form->field($model, 'email')->textInput(['placeholder'=>Yii::t('app', 'Enter your mail')])->label(false); ?>
        <div class="form-group">
            <button type="submit"><?= Yii::t('app','Subscribe') ?></button>
        </div>
    <?php ActiveForm::end(); ?>
</div>
