var comments = [];

comments.answewLink = '.ajax-comment-link.answer';
comments.editLink = '.ajax-comment-link.update';
comments.formConteiner = '#ajax-comment-form-conteiner';
comments.form = '#ajax-comment-form';
comments.body = '';
comments.timeout = 310;
comments.timer = false;


comments.init = function(){
    comments.answerInit();
    comments.editInit();
}
comments.editInit = function(){
    $(comments.editLink).unbind().click(function () {
        var lnk = $(this);
        comments.removeForm();
        $.get($(this).attr('href'), function (data) {
           comments.body = lnk.parents('.comment-body').html();
           lnk.parents('.comment-body').html('<div id="ajax-comment-form-conteiner">' + data + '</div>'); 
           comments.formSubmitInit();
        });
        return false;
    });
}


comments.answerInit = function(){
    $(comments.answewLink).unbind().click(function () {
        var lnk = $(this);
        comments.removeForm();
        $.get($(this).attr('href'), function (data) {
           lnk.parent().after('<div id="ajax-comment-form-conteiner">' + data + '</div>'); 
           comments.formSubmitInit();
        });
        return false;
    });
}
comments.removeForm = function(obj){
     if(comments.body){
            $(comments.formConteiner).parent().html(comments.body);
            comments.body = '';
            comments.init();
     }else{
            $(comments.formConteiner).remove();
    }
}

comments.formSubmitInit = function(){
    $(comments.form).on('submit', function (e) {
            e.preventDefault();   
            clearTimeout(comments.timer);
            comments.timer = setTimeout(function () {
                frm = $(comments.form);
                if (!$(comments.form).find('.has-error').length)
                {
                    comments.send();
                }
            }, comments.timeout);
    });
}

comments.send = function(){
    frm = $(comments.form);
    $.ajax({
        url: frm.attr('action'),
        type: 'post',
        dataType: 'html',
        data: frm.serialize(),
        success: function (data) {
                if(comments.body){
                    frm.parents('.level').replaceWith(data);
                }else{
                    frm.parents('.level').after(data);
                }
                frm.parent().remove();
                comments.init();
        }
    });
}

jQuery(document).ready(function () {
    comments.init();
});