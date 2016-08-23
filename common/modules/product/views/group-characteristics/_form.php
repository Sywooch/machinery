<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\modules\product\models\GroupCharacteristics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-characteristics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vocabularies')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TaxonomyVocabulary::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true
            ],
        ]);
 
    ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
