<?php

use yii\helpers\Html;
use common\modules\orders\widgets\delivery\Asset;
use common\modules\orders\widgets\delivery\helpers\DeliveryHelper;
use common\helpers\ModelHelper;

Asset::register($this);

?>

<div class="field-delivery-type">
    <h3>1. Тип доставки</h3>
    <div class="">
        <div class="btn-group custom" role="group" aria-label="...">
            <?php foreach(DeliveryHelper::getDeliveriesNames() as $index => $item):?>
                <label class="btn btn-default <?=$index == 'DeliveryDefault' ? 'active' : ''; ?>"><input type="radio" name="Orders[delivery]" value="<?=$index;?>" <?=$index == 'DeliveryDefault' ? 'checked' : ''; ?>> <?=$item;?></label>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="field-group" id="delivery-content">
    <?=$this->render(ModelHelper::getModelName($delivery->getModel()),[
        'model' => $delivery->getModel(),
        'form' => $form
    ]);?>
</div>




