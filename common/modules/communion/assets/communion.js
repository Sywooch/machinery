$(function(){
    $('body').on('submit', '.ajax-message-form', function(e){
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();
        $.post(form.attr('action'), data, function(d){
            console.log(d);
            if(form.attr('id') === 'communion-message-form'){
                $.get('', '', function(html){
                    var content = $('.messages-inner', $.parseHTML(html)).html();
                    $('.messages-inner').html(content);
                }, 'html');
            }
            form.trigger('reset');
        }, 'json');
    })
})