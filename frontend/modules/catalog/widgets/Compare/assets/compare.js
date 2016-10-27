var compare = [];
compare.id = '#compare-block-widget';
compare.class = '.chb-compare';
compare.buttons = $(compare.class);
compare.wiget = $(compare.id);
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
                    $(compare.class+'-'+data.id+' label').text('в сравнении')
                }else{
                    $(compare.class+'-'+data.id).removeClass('active');
                    $(compare.class+'-'+data.id+' label').text('сравнить')
                }
                compare.wiget.find('.items-count').text(data.count);
                if(data.count){
                    compare.wiget.find('a').addClass('active');
                }else{
                    compare.wiget.find('a').removeClass('active');
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
