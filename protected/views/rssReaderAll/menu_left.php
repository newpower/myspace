<p><b><?php echo Yii::t('timeline', 'Период') ?></b></p>

<div class="row period">
	<span class="period-title"><?php echo Yii::t('timeline', 'За все время') ?><br /><a href="#" class="ajax" id="period-trigger"><?php echo Yii::t('timeline', 'задать ограничения') ?></a></span>
	<span class="period-select">
	<?php echo Yii::t('timeline', 'С') ?> <input type='text' name='begin_date' id="begin_date" value='<?php echo Helpers::Date1($begin_date);?>'><a href="#" class="ajax" id="begin_date_a"><?php echo Yii::t('timeline', 'выберите') ?></a>

        <?php echo Yii::t('timeline', 'по') ?> <input type='text' name='end_date' id="end_date" value='<?php echo Helpers::Date1($end_date);?>'><a href="#" class="ajax" id="end_date_a"><?php echo Yii::t('timeline', 'выберите') ?></a>
	</span>
	<span class="delete-restrictions">
		<a class="ajax" href="#"><?php echo Yii::t('timeline', 'Убрать ограничение по времени') ?></a>
	</span>
</div>

    <hr style="margin-top: 15px;" />
    <div class="row search-materials">
        <fieldset>
            <input type="text" placeholder="<?php echo Yii::t('news', 'Искать по слову...'); ?>" class="text" id="news_search" name="text"
                   value="<?php echo $text; ?>"/>
        </fieldset>
    </div>
 
<script type="text/javascript">
	$(function () {
		var menu = $('#news-filter');

		var dateLabels = function (field, text) {
			if (field.id == "begin_date") {
				$('#begin_date_a').text(text);
			}
			else {
				$('#end_date_a').text(text);
			}
		}

		var dates = $( "#begin_date, #end_date" ).datepicker({
//			defaultDate: "+1w",
			changeMonth: function () {
				if (menu.is('.analytics-filter')) {
					return true;
				} else {
					return false;
				}
			},
			changeYear: function () {
				if (menu.is('.analytics-filter')) {
					return true;
				} else {
					return false;
				}
			},
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "begin_date" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
				if (this.id == "begin_date") {
					$('#begin_date_a').text(selectedDate);
				}
				else {
					$('#end_date_a').text(selectedDate);
				}
				$(this).closest('form').submit();
			},
			showButtonPanel: function () {
				if (menu.is('.analytics-filter')) {
					if (window.publication_period == 'year') {
						return true;
					}
				}
				return false;
			},
			onClose: function () {
				if (menu.is('.analytics-filter')) {
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					if (window.publication_period == 'year') {
						$(this).datepicker('setDate', new Date(year, 0, 1));
						dateLabels(this, year);
						$(this).closest('form').submit();
					}
					if (window.publication_period == 'month') {
						var newDate = new Date(year, month, 1);
						$(this).datepicker('setDate', newDate);
						dateLabels(this, newDate.mformat('m.Y'));
						$(this).closest('form').submit();
					}
				}
			},
			onChangeMonthYear: function(year, month, inst) {
				if (menu.is('.analytics-filter')) {
					var selDate = $(this).val();
					if (window.publication_period == 'year') {
//						var old_year = selDate;
						var newDate = new Date(year, 0, 1);
//						if (year != old_year) {
							$(this).datepicker('setDate', newDate);
							$(this).datepicker('hide');
//						}
						dateLabels(this, year);
						$(this).closest('form').submit();
					}
					if (window.publication_period == 'month') {
						var old_date = $(this).datepicker('getDate');
						var old_month = '';
						if (old_date) old_month = old_date.getMonth();
						if (month-1 != old_month) {
							var newDate = new Date(year, month - 1, 1);
							$(this).datepicker('setDate', newDate);
							$(this).datepicker('hide');
							dateLabels(this, newDate.mformat('m.Y'));
							$(this).closest('form').submit();
						}
					}
				}
			}
		});
		$('#begin_date_a').click(function (e) {
			e.preventDefault();
			$('#begin_date').datepicker('show');
		});
		$('#end_date_a').click(function (e) {
			e.preventDefault();
			$('#end_date').datepicker('show');
		});
		$('#period-trigger').click(function (e) {
			e.preventDefault();
			$(this).closest('.period').addClass('opened');
			$('#begin_date_a').click();
		});
		$('.delete-restrictions a').click(function(e){
			e.preventDefault();
			$(this).closest('.period').removeClass('opened');
			$('#begin_date').val('').datepicker('option', {minDate: null, maxDate: null});
			$('#begin_date_a,#end_date_a').text('выберите');
			$('#end_date').val('').datepicker('option', {minDate: null, maxDate: null});
			$(this).closest('form').submit();
		});

//		$('.left .tags ul input:checkbox').live('change',function(){
//			$(this).closest('form').submit();
//		});

		$('a.tagname').live('click', function(e){
		    e.preventDefault();
		    var that = $(this);
		    var contTags = $('.left.col .tags');
		    contTags.find('input[type="checkbox"]').each(function(){
			    var tag = $.trim($(this).val());
			    if (tag == that.text()) {
				    $(this).attr('checked','checked');
                    open_tag_parents($(this));
                    contTags.closest('form').submit();
                    return;
			    };
		    })

		    //$('body').animate({'scrollTop':0});

	    });

		menu.find('.filter-list input:checkbox').live('change', function () {
			var f = $(this).closest('.filter-container');
			if (f.find('.filter-list input:checked').length != f.find('.filter-list input:checkbox').length) {
				f.find('.f-check-all input').removeAttr('checked');
			} else {
				f.find('.f-check-all input').attr('checked', 'checked');
			}
			if ($(this).is(':checked')) {
//				$(this).closest('li').find('ul:first').slideDown(150);
//				$(this).parent().siblings('.hide_tree').css('display', 'block');
//				$(this).parent().siblings('.show_tree').hide();
			} else {
//				$(this).closest('li').find('ul').slideUp(150).end().find('input').removeAttr('checked');
//				$(this).parent().siblings('.show_tree').css('display', 'block');
//				$(this).parent().siblings('.hide_tree').hide();
			}
			$(this).closest('form').submit();
		});

		menu.find('.filter-list .show_tree').live('click', function (e) {
			e.preventDefault();
//			$(this).siblings('label').find('input').attr('checked', 'true').change();
			$(this).closest('li').find('ul:first').slideDown(150);
			$(this).hide();
			$(this).siblings('.hide_tree').css('display', 'block');
		});
		menu.find('.filter-list .hide_tree').live('click', function (e) {
			e.preventDefault();
//			$(this).siblings('label').find('input').removeAttr('checked').change();
			$(this).closest('li').find('ul').slideUp(150);
			$(this).hide();
			$(this).siblings('.show_tree').css('display', 'block');
		});

		var hash = function () {
			var tags = [];
			var users = [];
			$('input[name="tags[]"]:checked').each(function () {
				tags.push($(this).val());
			});
			if ($('input[name="user[]"]:checked').length != $('input[name="user[]"]').length) {
				$('input[name="user[]"]:checked').each(function () {
//					users.push($(this).closest('label').text());
					users.push($(this).val());
				});
			}
			var begin_date = menu.find('#begin_date').val();
			var end_date = menu.find('#end_date').val();
			var lh = [];
			if (users.length > 0) lh.push('users=' + users.join(', '));
			if (tags.length > 0) lh.push ('tags=' + tags.join(', '));
			if (begin_date != '') lh.push('begin_date=' + begin_date);
			if (end_date != '') lh.push('end_date=' + end_date);
			lh = lh.join('&');
			return lh;
		}

		$('#news-filter').submit(function (e) {
			var form = $(this);

			if (location.href.indexOf( form.attr('action') ) != -1) {
				e.preventDefault();
				form.find(':input[name=ajax]').val(1);
				var param = form.serialize();
//				if ($('input[name="user[]"]:checked').length == 0) {
//					$('input[name="user[]"]').each(function () {
//						$(this).attr('checked', 'checked');
//						param += '&user[]=' + $(this).val();
//					});
//				}

                var this_hash = hash();
				location.hash = this_hash;
//                if ($('.timeline').length > 0) {
//                    $('.timeline > h1').text($('.timeline > h1').data('defaultText') + ': ' + this_hash);
//                }
				$.get(form.attr('action'), param, function(data) {
					$('#layout-content').html(data);
					if ($('#layout-content').offset().top + $('#layout-content').height() < $(window).scrollTop()) {
						var scroll_top = $('#layout-content').offset().top - 20;
						$('html, body').animate({scrollTop: scroll_top}, 300);
					}
				});
			}
		});

        var open_tag_parents = function (checkbox) {
            var ul = checkbox.closest('ul');
            function rec () {
                if (!ul.is(':visible') && !ul.is('.filter-list')){
                    ul.show();
                    ul.closest('li').find('> .hide_tree').show();
                    ul.closest('li').find('> .show_tree').hide();
                    ul = ul.closest('li').closest('ul');
                    rec();
                }
            }
            rec();
        }

		if (window.location.hash) {
			var h = window.location.hash.replace('#', '');

			$('.news-list').css('visibility', 'hidden');

			var fields = h.split('&');
			var users = [];
			var tags = [];
			var begin_date ='';
			var end_date ='';
			$.each(fields, function (i, el) {
				var nv = el.split('=');
				var n = nv[0];
				var v = nv[1];
				if (n == 'users') {
					users = v.split(', ');
				}
				if (n == 'tags') {
					tags = v.split(', ');
				}
				if (n == 'begin_date') {
					begin_date = v;
				}
				if (n == 'end_date') {
					end_date = v;
				}


//				fields[i] = {};
//
//				fields[i].name = n;
//				fields[i].values = v.split(', ');

			});

			if (users.length > 0) {
				menu.find('input[name="user[]"]').each(function () {
					$(this).removeAttr('checked');
					if ($.inArray($(this).val(), users) > -1) {
						$(this).attr('checked', 'checked');
					}
				});
				menu.find('.f-check-all input').removeAttr('checked');
				menu.find('.f-check-all').addClass('short').prependTo(menu.find('.f-check-all').parent()[0]);
				menu.find('.filter-list-wr').addClass('opened').show();
			}
			if (begin_date != '') {
				menu.find('input[name="begin_date"]').val(begin_date);
				menu.find('#begin_date_a').text(begin_date);
				menu.find('#period-trigger').hide();
				menu.find('.period-select').show();
				menu.find('.period').addClass('opened');
			}
			if (end_date != '') {
				menu.find('input[name="end_date"]').val(end_date);
				menu.find('#end_date_a').text(end_date);
				menu.find('#period-trigger').hide();
				menu.find('.period-select').show();
				menu.find('.period').addClass('opened');
			}
			menu.find('input[name="tags[]"]').each(function () {
				if ($.inArray($(this).val(), tags) > -1) {
					$(this).attr('checked', 'checked');
					open_tag_parents($(this));
					var period = $(this).data('publication-period');
				}
			});
			var checked_tags = menu.find('.filter-list input:checked');
			if (window.definePeriod) {
				window.definePeriod(checked_tags);
			}
			$('#news-filter').submit();

		}

        var input = Helpers.debounce(function() {
            $(this).closest('form').submit();
        }, 500);
        $('#news-filter').on('change click keyup', '#news_search', input);

	});
</script>