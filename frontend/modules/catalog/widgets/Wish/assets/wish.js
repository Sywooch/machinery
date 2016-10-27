var wish = [];
wish.id = '#wish-block-widget';
wish.class = '.chb-wish';
wish.buttons = $(wish.class);
wish.wiget = $(wish.id);
wish.name = 'wish';
wish.authModal = $('#authModal');
wish.max = 500;
wish.maxMessage = 'Достигнут лимит избранного. Удалите лишние продукты.';
wish.url = '/catalog/wish/toggle';

wish.data = [];
wish.init = function(){
    wish.wiget.find('a').click(function(){
        if(!window.userId){
            return modal.show('Авторизация','Что бы просмотреть список желаний пройдите авторизацию.');
        }
    });

    wish.buttons.click(function(){
        var id = $(this).attr('data-id');
        var model = $(this).attr('data-model');
        wish.toggle(id,model);
    });
    
}
wish.toggle = function(id, model){
    

    if(!window.userId){
        return modal.show('Авторизация','Только авторизованные пользователи могут добавлять продукты в список желаний.');
    }
    
    $.post(wish.url,{id,model},function(data){
        if(data.status !== undefined){
            
            if(data.status == 'success'){
                if(data.action == 'added') {
                    $(wish.class+'-'+data.id).addClass('active')
                    $(wish.class+'-'+data.id+' label').text('в избранном')
                }else{
                    $(wish.class+'-'+data.id).removeClass('active');
                    $(wish.class+'-'+data.id+' label').text('в избранное')
                }
                wish.wiget.find('.items-count').text(data.count);
                if(data.count){
                    wish.wiget.find('a').addClass('active');
                }else{
                    wish.wiget.find('a').removeClass('active');
                }
            }else{
                alert(data.message);
            } 
        }
    });
    
    return;
}

$( document).ready(function() {
   wish.init();
});
