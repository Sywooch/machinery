<?php

use common\modules\address\widgets\Map\Asset;

Asset::register($this);

?>

    <div id="address-map-field-<?= $fieldId; ?>" class="address-map"></div>


<?php

if ($address && $address->id) {
    $this->registerJs('
            AddressMapWidget.initCoords = [' . $address->latitude . ', ' . $address->longitude . '];
            AddressMapWidget.addAddress(' . $address . ');
            AddressMapWidget.run(' . $fieldId . ');
            ');
}

?>