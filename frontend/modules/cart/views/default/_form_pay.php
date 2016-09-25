<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(['id' => 'orders-form']); ?>
    <?=
        $form->field($model, 'payment')
            ->radioList($model->getPaymentList(),
                [
                    'item' => function($index, $label, $name, $checked, $value) {
                        $checked = $checked ? 'checked' : '';                                    
                        $return = '<label class="styled-radio">';
                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" class="custom-radio" '.$checked.'>';
                        $return .= '<span class="input '.$checked.'"><i></i></span>';
                        $return .= '<span >' . $label . '</span>';
                        $return .= '</label>';

                        return $return;
                    }
                ]
            )
        ->label(false);
    ?>
    
    
    
    <?= Html::submitButton('Далее', ['class' => 'btn btn-orange-big']) ?>
    <?php ActiveForm::end(); ?>    

</div>
