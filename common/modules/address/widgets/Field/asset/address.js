//TODO: code review

var addressWidget = {
    url: '/address/default/geo',
    map: [],
    lastPlasemark: [],
    address: [],
    finderId: null,
    initCoords: [],
    data: [],

    run: function () {
        ymaps.ready(addressWidget.init);
    },

    init: function () {

        $(".address-container .find").click(function () {
            addressWidget.finderId = $(this).attr('data-id');
            addressWidget.request($("#address-finder-" + addressWidget.finderId).val());
            return false;
        });

        $('.address-map-field').each(function (index) {
            addressWidget.createMap(index);
            if(addressWidget.address[index]){
                addressWidget.showBalloon(index, addressWidget.address[index]);
            }
        });
        addressWidget.listInit();
    },

    addAddress: function(address){
        this.address[this.address.length] = address;
        return this;
    },

    request: function (data) {
        $.get(this.url, {address: data}, function (data) {
            addressWidget.data = data;
            addressWidget.showList(data);
        }, "json");
    },

    listInit: function () {
        if (this.finderId === null) {
            return;
        }
        var div = $('#address-find-' + addressWidget.finderId + '-results');
        if (!div.is(e.target)
            && div.has(e.target).length === 0) {
            div.hide();
            addressWidget.finderId = null;
        }
    },

    showList: function (data) {

        var html = '';
        for (var i in data) {
            var item = data[i];
            html += '<div class="itm" onClick="addressWidget.addressSelect(' + i + ');">';
            html += '<div class="addr">' + item.name + '</div>';
            html += '<div class="desc">' + item.description + '</div>';
            html += '</div>';
        }

        $('#address-find-' + addressWidget.finderId + '-results').html(html).show();
    },

    hideList: function () {
        $('#address-find-' + this.finderId + '-results').hide();
        this.finderId = null;
    },

    addressSelect: function (index) {
        var data = this.data[index];
        this.showBalloon(addressWidget.finderId, data);
        this.fillFields(addressWidget.finderId, data);
        this.hideList();
    },

    fillFields: function (index, item) {
        $('#address-finder-' + index).val(item.name);
        $('#address-' + index).val(item.latitude+', '+item.longitude);
    },

    showBalloon: function (index, item) {
        var content = '<h3>' + item.name + '</h3>';

        if(item.description){
            content += '<p>' + item.description + '</p>';
        }

        var myPlacemark = new ymaps.Placemark([item.latitude, item.longitude], {
            balloonContent: content
        }, {
            balloonPanelMaxMapArea: 0
        });
        this.map[index].geoObjects.add(myPlacemark);
        myPlacemark.balloon.open();
    },

    createMap: function (index) {
        this.map[index] = new ymaps.Map("address-map-field-" + index, {
            center: [parseFloat(addressWidget.initCoords[0]), parseFloat(addressWidget.initCoords[1])],
            zoom: 14,
            controls: ["zoomControl", "fullscreenControl"]
        });
    }

};





