<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use common\modules\store\OrdersAsset;
use common\modules\store\widgets\delivery\Delivery;

OrdersAsset::register($this);

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(['id' => 'orders-form', 'layout' => 'horizontal']); ?>
    <h2>Информация о получателе</h2>
    <div class="grey">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '+38(099) 999-99-99',
        ]); ?>
        <?= $form->field($model, 'phone2')->widget(MaskedInput::className(), [
            'mask' => '+38(099) 999-99-99',
        ]); ?>
        <?= $form->field($model, 'email')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' =>  'email'
            ],
        ]) ?>
    </div> 
    
    
    <h2>Информация о доставке</h2>
    <div class="delivery">
        <?= Delivery::widget(['form' => $form,'model' => $model]) ?>
    </div>
    <?= Html::submitButton('Далее', ['class' => 'btn btn-orange-big']) ?>
    <?php ActiveForm::end(); ?>    

</div>
