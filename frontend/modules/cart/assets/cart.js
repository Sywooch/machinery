var buyButton = [];
buyButton.buyConfirmModal = 'buyConfirmModal';
buyButton.btnClass = 'buy-button';
buyButton.addUrl = '/cart/default/add';
buyButton.init = function(){
   $('.'+this.btnClass).click(this.click);
}
buyButton.click = function(){
    var data = {entityId: $(this).attr('entityId'), entityName: $(this).attr('entity')};    
    $.ajax({
        url:buyButton.addUrl,
        data:data,
        success:function(data){
            if(data.success == undefined){
                return [];
            }
            buyButton.confirmModal(data.product);
            cartWidget.update(data);
        }
    }); 
}
buyButton.confirmModal = function(product){
    var modal = $('#'+this.buyConfirmModal);
    if(!modal.length){
        return false;
    }
    modal.find('.modal-body').html(this.product2TextFormater(product));
    modal.modal('show');
}
buyButton.product2TextFormater = function(product){
    var body = $('<div>').addClass('confirm-product-line')
    var title = $('<span>').addClass('title').text(product.title);
    var price = $('<span>').addClass('price').text('Цена:'+product.price);
    body.append(title);
    body.append(price);
    return body;
}

var cartWidget = [];
cartWidget.widgetId = 'cart-block-widget';
cartWidget.init = function(){}
cartWidget.update = function(data){  
    var cart = $('#'+this.widgetId);
    cart.find('.cart-items').html(data.formaters.items);
    cart.find('.cart-total').html(data.formaters.total);
}

var cart = [];
cart.cartId = 'cart-form';
cart.countContainer = 'count-container';
cart.page = $('#'+cart.cartId);
cart.timeoutId = 0;
cart.countUrl = '/cart/default/count';
cart.init = function(){
    if(!cart.page.length){
        return;
    }
    cart.page.submit(function(){
        return false;
    });
    cart.page.find('.cart-plus').click(function(){
        cart.plus(this);
        return false;
    });
    cart.page.find('.cart-minus').click(function(){
        cart.minus(this);
        return false;
    });
    
    cart.page.find('.count-input').change(function(j){
        cart.setCount(this);
        return false;
    });
    
}
cart.setCount = function(e){
        var b = $(e);
        var i = b.attr("data-id");
        var c = b.val() * 1;
        if(c < 1)  c = 1;
        b.val(c);
        cart.deferredCount(i,c);
}
cart.plus = function(e){
    var b = $(e).parents('.'+cart.countContainer).find('input');
    var i = b.attr("data-id"); 
    var c = b.val() * 1 + 1;
    b.val(c);
    cart.deferredCount(i,c);
}
cart.minus = function(e){
    var b = $(e).parents('.'+cart.countContainer).find('input');
    var i = b.attr("data-id"); 
    var c = b.val() * 1 - 1;
    if(c < 1) c = 1;
    b.val(c)
    cart.deferredCount(i,c);
}
cart.deferredCount = function(id, count)
{
    clearTimeout(cart.timeoutId);
    cart.timeoutId = setTimeout('cart.count('+id+','+count+');', 700);
}
cart.count = function(id, count)
{
    var data = {id:id, count:count};  
    $.ajax({
        url: cart.countUrl,
        data: data,
        success:function(data){
            if(data.success == undefined){
                return [];
            }
            cartWidget.update(data);
            cart.updateItem(data);
            cart.updateOrder(data);
        }
    });
}
cart.updateOrder = function(data){
    $('.cart-total').html(data.formaters.total); 
}
cart.updateItem = function(data){
    var item = $('#order-item-'+data.item.id);
    item.find('.item-total').text(data.formaters.itemTotal);
}

$( document ).ready(function(){
   buyButton.init(); 
   cartWidget.init();
   cart.init();
});

