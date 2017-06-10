
var AddressMapWidget = {
    map: null,
    index: null,
    addresses: [],
    finderId: null,
    initCoords: [],

    run: function (index) {
        this.index = index;
        ymaps.ready(AddressMapWidget.init);
    },

    init: function () {
        AddressMapWidget.createMap();
        AddressMapWidget.addresses.forEach(function(address){
            AddressMapWidget.addPoint(address);
        });

    },

    addAddress: function(address){
        this.addresses[this.addresses.length] = address;
        return this;
    },

    createMap: function () {
        AddressMapWidget.map = new ymaps.Map("address-map-field-"+AddressMapWidget.index, {
            center: [parseFloat(AddressMapWidget.initCoords[0]), parseFloat(AddressMapWidget.initCoords[1])],
            zoom: 14,
            controls: ['zoomControl']
        });

        AddressMapWidget.map.behaviors.disable('scrollZoom');

    },

    addPoint: function(address){
        var GeoObject = new ymaps.Placemark([address.latitude, address.longitude], {
        }, {
            hideIconOnBalloonOpen: false,
            iconLayout: 'default#image',
            iconImageHref: '/images/points.png',
            iconImageSize: [20, 20],
            iconImageClipRect: [[25, 20], [45, 40]],
            iconImageOffset: [-10, -10]
        });

        AddressMapWidget
            .map
            .geoObjects
            .add(GeoObject);
    }
}





