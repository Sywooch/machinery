$( document ).ready(function(){delivery.init();});
var delivery = [];
delivery.delivery = $('.delivery');

delivery.init = function(){
    this.deliveryInit();
}

delivery.deliveryInit = function(){
    delivery.initRadio();
}
delivery.initRadio = function(){
    $('.field-delivery-type input').change(function(){
        $(this).parents('.btn-group.custom').find('label').removeClass('active');
        $(this).parent().addClass('active');
    });
    delivery.delivery.find('input[name="Orders[delivery]"]').click(function(){
        delivery.loadFields(this);
    });
}

delivery.loadFields = function(obj){
    var name = $(obj).val();
    $.get('/orders/default/load', {name:name}, function(data){ 
        delivery.delivery.find('#delivery-content').html(data);
        radio.radioInit();
    });
}