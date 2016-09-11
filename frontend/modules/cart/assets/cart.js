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
    item.find('.item-total').html(data.formaters.itemTotal);
    item.find('.item-old-total').html(data.formaters.itemRealTotal);
}

cart.initMultiDelete = function(){
    cart.page.find('#multi-delete-button').click(function(){
        var link = '';
        cart.page.find('.chb').each(function(){
            if($(this).val() == 1){
                link += '&id[]='+$(this).attr('data-id');
            }
        });
        location.href = '/cart/default/remove?' + link;
        return false;
    });
   cart.page.find('#chb_all').change(function(){
      cart.page.find('.chb').val($(this).val()).checkboxX('refresh');  
      cart.multiDeleteAction();
   }); 
   cart.page.find('.chb').change(function(){
       var checked = true;
       cart.page.find('.chb').each(function(){
           checked *= $(this).val();
       })
       cart.page.find('#chb_all').val(checked).checkboxX('refresh');
       cart.multiDeleteAction();
   });
}

cart.multiDeleteAction = function(){
    var count = 0;
    cart.page.find('.chb').each(function(){
           count += $(this).val() * 1;
    })
    cart.page.find('#multi-text').text('Выбрано '+count+' '+cart.declension(count, ['продукт','продукта','продуктов']));
    
    if(count){
      cart.page.find('#multi-text').show();  
      cart.page.find('#multi-delete-button').show();
    }else{
      cart.page.find('#multi-text').hide();  
      cart.page.find('#multi-delete-button').hide();
    }
}

cart.declension = function (num, expressions) {
    var result;
    count = num % 100;
    if (count >= 5 && count <= 20) {
        result = expressions['2'];
    } else {
        count = count % 10;
        if (count == 1) {
            result = expressions['0'];
        } else if (count >= 2 && count <= 4) {
            result = expressions['1'];
        } else {
            result = expressions['2'];
        }
    }
    return result;
}


$( document ).ready(function(){
   buyButton.init(); 
   cartWidget.init();
   cart.init();
   cart.initMultiDelete();
});

