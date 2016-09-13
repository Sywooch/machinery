<?php

use yii\bootstrap\ActiveForm;
use common\modules\orders\widgets\delivery\helpers\DeliveryHelper;
use backend\models\ShopAddress;


if(!isset($form)){
    $form = new ActiveForm();
}
$form->layout = ''
?>

<?=
    $form->field($model, 'address')
        ->radioList(DeliveryHelper::getAddress(ShopAddress::find()->all()),
            [
                'item' => function($index, $label, $name, $checked, $value) {
           
                    $checked = $checked ? 'checked' : '';                                    
                    $return = '<label class="styled-radio">';
                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" class="custom-radio" '.$checked.'>';
                    $return .= '<span class="input '.$checked.'"><i></i></span>';
                    $return .= '<span class="delivery-address">' . $label . '</span>';
                    $return .= '</label>';

                    return $return;
                }
            ]
        )
    ->label(false);
?>

<h3>2. Ближайшая дата самовывоза</h3>

<?= $form->field($model, 'date')->dropDownList(DeliveryHelper::getReceiveDates());
?>
   


