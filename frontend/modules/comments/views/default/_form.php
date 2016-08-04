<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<style>
	#ajax-comment-form{ padding: 30px;}
	#ajax-comment-form label{ margin-right: 40px;}
</style>

<?php

$form = ActiveForm::begin([
			'id' => 'ajax-comment-form',
			'options' => ['data-pjax' => 1]
		])
?>

<?= $form->field($model, 'comment', ['template' => '{input}{error}'])->textarea(['rows' => 2]); ?>

<?= Html::submitButton('Отправить', ['class' => 'btn btn-default btn-block']) ?>

<?php ActiveForm::end(); ?>

