var compare = [];
compare.class = '.chb-compare';
compare.buttons = $(compare.class);
compare.name = 'compare';
compare.max = 100;
compare.maxMessage = 'Достигнут лимит сравнений. Удалите лишние продукты.';
compare.url = '/catalog/compare/toggle';

compare.data = [];
compare.init = function(){
 
    compare.buttons.click(function(){
        var id = $(this).attr('data-id');
        var model = $(this).attr('data-model');
        compare.toggle(id,model);
    });
    
}
compare.toggle = function(id, model){
    
    $.post(compare.url,{id,model},function(data){
        if(data.status !== undefined){
            
            if(data.status == 'success'){
                if(data.action == 'added') {
                    $(compare.class+'-'+data.id).addClass('active')
                }else{
                    $(compare.class+'-'+data.id).removeClass('active');
                }
            }else{
                alert(data.message);
            } 
        }
    });
    
    return;
}

$( document).ready(function() {
   compare.init();
});
