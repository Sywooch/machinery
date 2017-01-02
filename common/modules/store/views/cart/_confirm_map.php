<?php
use common\modules\store\models\address\ShopAddressSearch;
?>

<div class="order-panel-conteiner">
 Забрать и оплатить заказ вы можете <?=$model->data->delivery->data->date;?> по адресу: <?=$model->data->delivery->data->address; ?>
</div>
<div id="map"></div>
<?php

$address = ShopAddressSearch::findAddressByString($model->data->delivery->data->address);
$coordinates = explode(',',$address->coordinates);
?>
<script>
    
    function initMap() {
        var addrLatLng = {lat: <?=$coordinates[0];?>, lng: <?=$coordinates[1];?>};

        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: addrLatLng ,
          scrollwheel: false,
          zoom: 15
        });

        // Create a marker and set its position.
        var marker = new google.maps.Marker({
          map: map,
          position: addrLatLng,
          title: 'туточки'
        });
      }

    
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6UjotZhnISH5QmaA1aAHWBxwg4yBD_iE&callback=initMap" async defer></script>


