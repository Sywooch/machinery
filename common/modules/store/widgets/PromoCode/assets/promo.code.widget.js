var promoWidget = [];
promoWidget.field = $('#promocodes-code');
promoWidget.form = $('#promo-code');
promoWidget.init = function(){
    promoWidget.field.keyup(function(){
        var code = $(this).val().replace(/\_/g, "");
        if(code.length == 15){
            promoWidget.form.find('button').prop('disabled',false);
        }else{
             promoWidget.form.find('button').prop('disabled',true);
        }
    });
    promoWidget.form.find('button').click(function(){
        promoWidget.checkCode(promoWidget.field.val().replace(/\_/g, ""));
        return false;
    });
}

promoWidget.checkCode = function(code){
   $.get('/orders/promo-codes/use-promo-ajax',{code:code},function(data){
       if(data.status == 'error'){
           promoWidget.field.next().html(data.message);
       }else{
           location.reload();
       }
   });
}

$(document).ready(function() {
    promoWidget.init(); 
});