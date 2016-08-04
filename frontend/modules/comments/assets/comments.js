var ajax_comment_old_text = '';
var ajax_comment_timeout = false;
jQuery(document).ready(function () {

	$('.ajax-comment-link.answer').click(function () {

		lnk = $(this);

		if ($("#ajax-comment-form-conteiner.update").length)
			$("#ajax-comment-form-conteiner.update").parent().html(ajax_comment_old_text);
		ajax_comment_old_text = lnk.parents(".comment-body").find('.comment').html();
		$("#ajax-comment-form-conteiner").remove();

		$.get($(this).attr('href'), function (data) {

			lnk.parent().after('<div id="ajax-comment-form-conteiner">' + data + '</div>');
			frm = $('#ajax-comment-form');
			frm.on('submit', function (e) {
				e.preventDefault();   // что бы не было перезагрузки при сабмите формы

				clearTimeout(ajax_comment_timeout);
				ajax_comment_timeout = setTimeout(function () {

					frm = $('#ajax-comment-form');
					if (!frm.find('.has-error').length)
					{


						$.ajax({
							url: frm.attr('action'),
							type: 'post',
							dataType: 'html',
							data: frm.serialize(),
							success: function (data) {
								frm.parents('.level').after(data);
								frm.parent().remove();

							}
						});

					}

				}, 310);

			});

		});

		return false; // что бы не было перехода на страницу

	});




	$('.ajax-comment-link.update').click(function () {



		var params = 'scrollbars=yes,resizable=no,status=no,location=no,toolbar=no,menubar=no' +
				'width=500,height=800,left=100,top=100';
		window.open($(this).attr('href'), 'Редактрование', params);


		return false;


		lnk = $(this);

		if ($("#ajax-comment-form-conteiner.update").length)
			$("#ajax-comment-form-conteiner.update").parent().html(ajax_comment_old_text);
		ajax_comment_old_text = lnk.parents(".comment-body").find('.comment').html();
		$("#ajax-comment-form-conteiner").remove();




		$.get($(this).attr('href'), function (data) {


			var params = 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no' +
					'width=100,height=100,left=100,top=100';
			window.open('/', 'test', params);

			return false;


			lnk.parent().prev().html('<div id="ajax-comment-form-conteiner" class="update">' + data + '</div>');
			frm = $('#ajax-comment-form');
			frm.on('submit', function (e) {
				e.preventDefault();   // что бы не было перезагрузки при сабмите формы

				clearTimeout(ajax_comment_timeout);
				ajax_comment_timeout = setTimeout(function () {

					frm = $('#ajax-comment-form');
					if (!frm.find('.has-error').length)
					{


						$.ajax({
							url: frm.attr('action'),
							type: 'post',
							dataType: 'html',
							data: frm.serialize(),
							success: function (data) {
								frm.parents('.comment').html(data);
								frm.parent().remove();

							}
						});

					}

				}, 310);

			});

		});

		return false; // что бы не было перехода на страницу

	});










});