<?php

namespace common\modules\address\widgets\Field;

use yii;
use common\modules\address\helpers\AddressHelper;
use yii\db\ActiveRecordInterface;

Asset::register($this);

$className = $className ?? '';
$attribute = $attribute ?? '';
$address = $address ?? '';
$fieldId = $fieldId ?? '';

$name = $className . '[' . $attribute . ']';
$findName = $className . '[addressFindField]';

if (Yii::$app->request->isPost) {
    $coordinates = Yii::$app->request->post($className)[$attribute];
    $address = Yii::$app->request->post($className)['addressFindField'];
} elseif ($address instanceof ActiveRecordInterface) {
    $coordinates = AddressHelper::getCoordinates($address);
    $address = $address->name;
} else {
    $coordinates = '';
    $address = '';
}

?>
    <div class="address-container">
        <div class="input-group">
            <input id="address-<?= $fieldId; ?>" class="form-control" type="hidden"
                   value='<?= $coordinates; ?>'
                   name="<?= $name ?>">
            <input id="address-finder-<?= $fieldId; ?>" class="form-control" type="text"
                   value='<?= $address; ?>'
                   name="<?= $findName; ?>">
            <div id="address-find-<?= $fieldId; ?>" class="input-group-addon find" data-id="<?= $fieldId; ?>">Найти</div>
        </div>
        <div class="description">Например, <a href="#">г. Киев, ул. Саксаганского 3 </a></div>
        <div id="address-find-<?= $fieldId; ?>-results" class="results">

        </div>
    </div>
    <div id="address-map-field-<?= $fieldId; ?>" class="address-map-field"></div>


    <?php

$script = <<< JS
        addressWidget.initCoords = [50.450097, 30.523397];
        addressWidget.run();
JS;

$this->registerJs($script,
    \yii\web\View::POS_READY
);

if ($address) {
    $address = [
        'name' => $address,
        'description' => '',
        'latitude' => explode(',', $coordinates)[0],
        'longitude' => explode(',', $coordinates)[1]
    ];
    $this->registerJs('addressWidget.addAddress(' . json_encode($address) . ');');
}


?>