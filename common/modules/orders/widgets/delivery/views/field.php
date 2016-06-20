<?php

use yii\helpers\Html;
use common\modules\orders\widgets\delivery\Asset;
use common\modules\orders\widgets\delivery\helpers\DeliveryHelper;
use common\helpers\ModelHelper;

Asset::register($this);

?>
<?= Html::activeRadioList($model, 'delivery', DeliveryHelper::getDeliveriesNames()); ?>

<div class="field-group">
    <?=$this->render(ModelHelper::getModelName($delivery->getModel()),[
        'model' => $delivery->getModel()
    ]);?>
</div>
