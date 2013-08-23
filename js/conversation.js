$(function () {

	var onload = false;
	var show_side = function (el, c_item, prev_height) {

		//reset
		$('#conversations .left').removeAttr('style');
		$('.users-stage-wr').removeAttr('style');
		$('.users-stage').removeAttr('style');
		$('.c-item.active').removeClass('active').removeAttr('style').removeClass('shadow-top').removeClass('shadow-bottom');
		$(window).unbind('scroll');
		$('.c_item_ph').remove();

		var frame = $('.users-stage-wr');
		var inner = $('.users-stage');
		var users_height = inner.height();
		var el_height = el.innerHeight();
		var item_height = c_item.innerHeight();
		var top = c_item.offset().top - $('#conversations .left').offset().top;
		var users_top = $('#conversations .left').offset().top;
		var u_top = users_top;
		var comment_input = el.find('input[type=text]');
		var big_prev_c = false;
		if (prev_height > users_height) big_prev_c = true;

		$('#conv_place').height(prev_height);

		if (el_height > $(window).height()) {
			var allow_scroll = true;
		} else {
			var allow_scroll = false;
		}

		var item_top = c_item.offset().top;
		var item_top_in = item_top - users_top;
		var item_bottom_in = users_height - item_top_in;

//			$('.c-item').not(c_item[0]).addClass('milk');
		c_item.addClass('active');
		var iph = $('<div class="c_item_ph"></div>').insertAfter(c_item);
		iph.height(item_height).hide();



		el.addClass('opened');
		var el_top = 0
		el_height = el_height + parseInt(el.css('padding-top')) + parseInt(el.css('padding-bottom'));
		if (el_height < users_height) {
//			$('#conversations .left').height(users_height);
			if (el_height < item_height) {
				el_top = item_top_in - 1
			} else {
				el_top = item_top_in - (el_height - item_height)/2;
				if (el_top + el_height > users_height) el_top = users_height - el_height;
				if (el_top < 0) el_top = 0;
			}
		} else {
//			$('#conversations .left').height(el_height);
		}
		el.css({'margin-top': el_top});
			el
//				.show();
			.animate({
				opacity: 'show',
				width: 'show'
			}, 200);

		if (el_height < users_height) {
			$('#conv_place').animate({height: el_height +20}, 700, function () {$(this).css('height', 'auto');});
		} else {
//			$('#conv_place').height(el_height +30);
			$('#conv_place').css('height', 'auto');
		}

		var messages = el.find('.item');
		var first_unread_top = users_top + 10;
		messages.each(function () {
			if($(this).is('.unread')) {
				return false;
			}
			first_unread_top += $(this).outerHeight() + parseInt($(this).css('margin-bottom'));
		});

		var scroll_to_m = function () {
			var scroll_top = users_top + el_height + el_top + 30 - $(window).height();
			if (scroll_top > first_unread_top) scroll_top = first_unread_top;
			if (!c_item.is('.faq')) {
				$('html, body').animate({scrollTop: scroll_top}, 800, function () {
					if (scroll_top < first_unread_top) {
	//					el.find('.add-message input').focus();
	//					el.find('.add-comment input').focus();
						comment_input.focus();
					}
				});
			}
		}

		if (el_height > users_height || el_height > $(window).height()) {
			scroll_to_m();
		}
		else if (el_height + el_top + users_top - 40 > $(window).scrollTop() + $(window).height()) {
			scroll_to_m();
		}
		else {
//			el.find('.add-message input').focus();
//			el.find('.add-comment input').focus();
			comment_input.focus();
		}

		$(window).scroll(scroll_messages);

		function scroll_messages () {
			if (allow_scroll) {
				var st = $(window).scrollTop();
				var wh = $(window).height();
				var y = c_item.offset().top;
				if (st > item_top) {
					c_item.css({
						'position': 'fixed',
						'top': 0,
						'bottom': 'auto'
					}).addClass('shadow-bottom');
					iph.show();

				} else if (st < item_top + item_height - wh) {
					c_item.css({
						'position': 'fixed',
						'top': 'auto',
						'bottom': 0
					}).addClass('shadow-top');
					iph.show();

				} else {
					c_item.removeAttr('style').removeClass('shadow-top').removeClass('shadow-bottom');
					iph.hide();
				}
			}
		}
	}

	$('.c-item').click(function (e) {
		e.stopPropagation();
		e.preventDefault();
		if (!$(this).is('.active')) {
		var prev_height = $('#conv_place').find('.conv').height();
		var prev_conv = $('#conv_place .conv').find('.b-conversation .list .item:first').attr('data_conversation_id');
		if ($('.c-item.active').find('.b-conversation').is('.no-conversation') && typeof(prev_conv) != 'undefined') {
			$('.c-item.active').find('.show-all-comments').attr('href', $('.c-item.active').find('.show-all-comments').attr('href') + prev_conv);
			$('.c-item.active').find('.b-conversation').removeClass('no-conversation');
		}

		var c_item = $(this);
		window.activeConversationUser = c_item.find('.b-conversation').data('userFio');
		var _el = c_item.find('.conv');
		var el = _el.clone(true);
		el.css({'visibility': 'hidden', 'height': '0px'}).appendTo('#conv_place');
		if (c_item.is('.faq')) el.addClass('faq-comments');
		var top = c_item.offset().top - $('#conversations').offset().top;
		var is_conv = true;
		if (_el.find('.b-conversation').is('.no-conversation')) is_conv = false;

		var show_all = el.find('.load-comments-link');
		var items = el.find('.list .item');
		if (items.length == 0) is_conv = false;
		if (onload) {
			is_conv = true;
			onload = false;
		}
		if (is_conv) {
			$.ajax({
				url: show_all.attr('href'),
				dataType: 'json',
				success: function(data) {
					if (data.status == 'success') {
					var list = el.find('.list').empty();

					$.each(data.list, function (ind, val) {
						if (val.user_id == tuid) {
							val.own = 1;
						} else {
							val.own = 0;
						}
					});
					if ($('.b-conversation').length > 0) {
						$.tmpl(
							'message_item_template',
							data
						).appendTo(list);
					} else if ($('.b-comment').length > 0) {
						$.tmpl(
							'comment_item_template1',
							data
						).appendTo(list);
					}
					el.find('div.count-comments').remove();
					el.removeAttr('style').prev().remove();
//						el.removeAttr('style').prev().animate({height: 0, opacity: 0}, 200, function () {$(this).remove()});
					show_side(el, c_item, prev_height);
					}
				}
			});
		} else {
			el.find('div.count-comments').remove();
			el.find('.b-conversation').prepend('<div style="padding-bottom: 10px">'+t('У вас пока не было переписки с этим участником')+'</div>')
			el.removeAttr('style').prev().remove();
//				el.removeAttr('style').prev().animate({height: 0, opacity: 0}, 200, function () {$(this).remove()});
			show_side(el, c_item, prev_height);
		}

	}
	});

	if (window.location.hash) {
		onload = true;
        if ($('#conversations').is('.support')) {
            var quest_id = parseInt(window.location.hash.replace('#', ''));
            $('.c-item .b-comment .list').each(function(){
                if ($(this).is('.comment-list-'+quest_id)) {
                    $(this).closest('.c-item').click();
                }
            });
        } else {
            var user_id = parseInt(window.location.hash.split('/')[0].replace('#', ''));
            $('.b-conversation').each(function () {
                if ($(this).data('userId') == user_id) {
                    $(this).click();
                }
            });
        }
	}
});