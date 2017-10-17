$('form.translate input').change(function () {

    var action = $(this).parents('form').attr('action');
    var id = $(this).parents('form').find('#message-id').val();
    var language = $(this).parents('form').find('#message-language').val();
    $.post(action+'?id='+id+'&language='+language+'&ajax=1', $(this).parents('form').serialize(), function (data) {

    });
});