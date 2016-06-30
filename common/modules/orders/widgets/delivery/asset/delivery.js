$( document ).ready(function(){delivery.init();});
var delivery = [];
delivery.delivery = $('#orders-delivery');
delivery.init = function(){
    this.deliveryInit();
}

delivery.deliveryInit = function(){
    delivery.delivery.find('input[name="Orders[delivery]"]').click(function(){
        delivery.loadFields(this);
    });
    if(!delivery.delivery.find('input').length){
        delivery.loadFields(delivery.form.find('input[name="Orders[delivery]"]:checked'));
    }
}
delivery.loadFields = function(obj){
    var name = $(obj).val();
    $.get('/orders/default/load', {name:name}, function(data){ 
        console.log(data);
        delivery.delivery.next().html(data);
    });
}