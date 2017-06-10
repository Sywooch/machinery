<div class="static-map">
    <!--&pt=<?= $address->longitude ?>,<?= $address->latitude ?>-->
    <img
        src="https://static-maps.yandex.ru/1.x/?ll=<?= $address->longitude ?>,<?= $address->latitude ?>&size=<?= implode(',', $size) ?>&spn=0.016457,0.00619&l=map" class="img-responsive">
    <img class="marker" src="/images/marker.png" width="23" height="37">
</div>

