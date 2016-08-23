<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\product\models\ProductShortSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-short-settings-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'vocabulary_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TaxonomyVocabulary::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => false
            ],
        ]);
 
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
