var Comments = {
    answewLink: '.ajax-comment-link.answer',
    editLink: '.ajax-comment-link.update',
    formConteiner: '#ajax-comment-form-conteiner',
    form: '#ajax-comment-form',
    body: '',
    timeout: 310,
    timer: false,

    init: function () {
        Comments.answerInit();
        Comments.editInit();
    },

    answerInit: function () {
        $(this.answewLink).unbind().click(function () {
            var lnk = $(this);
            Comments.removeForm();
            $.get($(this).attr('href'), function (data) {
                lnk.parent().after('<div id="ajax-comment-form-conteiner">' + data + '</div>');
                Comments.formSubmitInit();
            });
            return false;
        });
    },

    formSubmitInit: function () {
        $(Comments.form).on('submit', function (e) {
            e.preventDefault();
            clearTimeout(Comments.timer);
            Comments.timer = setTimeout(function () {
                frm = $(Comments.form);
                if (!$(Comments.form).find('.has-error').length) {
                    Comments.send();
                }
            }, Comments.timeout);
        });
    },

    removeForm: function () {
        if (Comments.body) {
            $(Comments.formConteiner).parent().html(Comments.body);
            Comments.body = '';
            Comments.init();
        } else {
            $(Comments.formConteiner).remove();
        }
    },

    editInit: function () {
        $(Comments.editLink).unbind().click(function () {
            var lnk = $(this);
            Comments.removeForm();
            $.get($(this).attr('href'), function (data) {
                Comments.body = lnk.parents('.comment-body').html();
                lnk.parents('.comment-body').html('<div id="ajax-comment-form-conteiner">' + data + '</div>');
                Comments.formSubmitInit();
            });
            return false;
        });
    },

    send: function () {
        frm = $(Comments.form);
        $.ajax({
            url: frm.attr('action'),
            type: 'post',
            dataType: 'html',
            data: frm.serialize(),
            success: function (data) {
                if (Comments.body) {
                    frm.parents('.level').replaceWith(data);
                } else {
                    frm.parents('.level').after(data);
                }
                frm.parent().remove();
                Comments.init();
            }
        });
    }
};


jQuery(document).ready(function () {
    Comments.init();
});