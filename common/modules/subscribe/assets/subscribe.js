$(function(){

    $('body').on('submit', '#subscribe-form', function(e){
        e.preventDefault();
        var form = $(this);
        $.post(form.attr('action'), form.serialize(), function(d){
            if(d.status == 'ok'){
                form.trigger('reset');
                $('#status-modal').modal('show');
            }
        }, 'json');
    });
    // $('#status-modal').modal('show');
})