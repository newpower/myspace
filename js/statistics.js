$(function () {
	
    $('.period #date1').datepicker({
        changeMonth: true,
        changeYear: true,
        altField: '#market_year_begin',
        altFormat: "yy-mm-dd",
		showButtonPanel: true,
		onSelect: function (dateText, inst) {
			var chart_item = $('.chart-item');
			change_hash(chart_item);
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			var chart_item = $('.chart-item');
			if (chart_item.is('.discrete-year')) {
				$(this).datepicker('setDate', new Date(year, 0, 1));
			}
			if (chart_item.is('.discrete-month')) {
				$(this).datepicker('setDate', new Date(year, month, 1));
			}
		},
		beforeShow: function() {
			selDate = $(this).val();
//			if ((selDate = $(this).val()).length > 0)
			if (selDate && selDate != '')
			{
//				iYear = selDate.substring(selDate.length - 4, selDate.length);
//				iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5),
//					$(this).datepicker('option', 'monthNames'));
				var chart_item = $('.chart-item');
				if (chart_item.is('.discrete-year')) {
					$(this).datepicker('option', 'defaultDate', new Date(selDate, 1, 1));
				}
				if (chart_item.is('.discrete-month')) {
					var date = parseDate(selDate, 'mm.yy');
					var month = parseInt(selDate.split('.')[0])-1;
					var year = selDate.split('.')[1];
					$(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
				}
//				$(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
//				$(this).datepicker('setDate', new Date(iYear, iMonth, 1));
			}
		},
		onChangeMonthYear: function(year, month, inst) {
			var selDate = $(this).val();
			var chart_item = $('.chart-item');
			if (chart_item.is('.discrete-year')) {
				var old_year = selDate;
				if (year != old_year) {
					$(this).datepicker('setDate', new Date(year, 0, 1));
					$(this).datepicker('hide');
					$(this).blur();
					change_hash(chart_item);
				}
			}
			if (chart_item.is('.discrete-month')) {
				var old_month = ''
//				var old_date = parseDate(selDate, 'mm.yy');
//				if (old_date) old_month = old_date.getMonth();
				old_month = parseInt(selDate.split('.')[0]);
				if (month != old_month) {
//					$(this).datepicker('setDate', new Date(year, month, 1));
					$(this).datepicker('hide');
					$(this).blur();
					change_hash(chart_item);
				}
			}
		}
    });
    $('.period #date2').datepicker({
        changeMonth: true,
        changeYear: true,
        altField: '#market_year_end',
        altFormat: "yy-mm-dd",
		showButtonPanel: true,
		onSelect: function (dateText, inst) {
			var chart_item = $('.chart-item');
			change_hash(chart_item);
		},
		onClose: function(dateText, inst) {
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			var chart_item = $('.chart-item');
			if (chart_item.is('.discrete-year')) {
				$(this).datepicker('setDate', new Date(year, 0, 1));
			}
			if (chart_item.is('.discrete-month')) {
				$(this).datepicker('setDate', new Date(year, month, 1));
			}
		},
		beforeShow: function() {
			selDate = $(this).val();
//			if ((selDate = $(this).val()).length > 0)
			if (selDate && selDate != '')
			{
//				iYear = selDate.substring(selDate.length - 4, selDate.length);
//				iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5),
//					$(this).datepicker('option', 'monthNames'));
				var chart_item = $('.chart-item');
				if (chart_item.is('.discrete-year')) {
					$(this).datepicker('option', 'defaultDate', new Date(selDate, 1, 1));
				}
				if (chart_item.is('.discrete-month')) {
					var date = parseDate(selDate, 'mm.yy');
					var month = parseInt(selDate.split('.')[0])-1;
					var year = selDate.split('.')[1];
					$(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
				}
//				$(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
//				$(this).datepicker('setDate', new Date(iYear, iMonth, 1));
			}
		},
		onChangeMonthYear: function(year, month, inst) {
			var selDate = $(this).val();
			var chart_item = $('.chart-item');
			if (chart_item.is('.discrete-year')) {
				var old_year = selDate;
				if (year != old_year) {
					$(this).datepicker('setDate', new Date(year, 0, 1));
					$(this).datepicker('hide');
					$(this).blur();
					change_hash(chart_item);
				}
			}
			if (chart_item.is('.discrete-month')) {
				var old_month = ''
//				var old_date = parseDate(selDate, 'mm.yy');
//				if (old_date) old_month = old_date.getMonth();
//				old_month = parseInt(selDate.split('.')[0]) - 1;
				if (month != old_month) {
//					$(this).datepicker('setDate', new Date(year, month, 1));
					$(this).datepicker('hide');
//					$(this).blur();
					change_hash(chart_item);
				}
			}
		}
    });
	$(document).on('change', '.discrete-year .ui-datepicker-year', function(){});

	$('.close a').live('click', function(e) {
		var el = $(this);
		// if (el.closest('.chart-container').length != 0) {
		hideChartPlace()
		// } else if (el.closest('.map-wr').length != 0) {
		hideMap()
		// }
	})


});

$(function () {
    $.getJSON('/statistics/pricesFilter', function(data) {
        $.each(data, function(k, v) {
            var _sel = $('select[name=' + k + ']');
            if (_sel && _sel.length > 0) {
                var val = _sel.val();
                _sel.html(v).val(val);
            }
        });
    })
});

$(function () {
	$('.page-title').hide();
    $('input[name="date1"]').change(function () {
        $('input[name="date_begin"]').val($('input[name="market_year_begin"]').val());
//        change_hash($(this).closest('.chart-item'));
		hideMap();
    });
    $('input[name="date2"]').change(function () {
        $('input[name="date_end"]').val($('input[name="market_year_end"]').val());
//        change_hash($(this).closest('.chart-item'));
		hideMap();
    });
    $('#discrete').change(function () {
		var val = $(this).val();
		chartItemDiscreteClass(val);
		changeDatepickerFormat(val);
        change_hash($(this).closest('.chart-item'));
		hideMap();
    });
    $('#chart_type').change(function () {
        change_hash($(this).closest('.chart-item'));
    });
    $(document).on('change', '.legend-place .series_type', function(){
		hideMap();
        set_series_type($(this).closest('.chart-item'), $(this));
    });
	$(document).on('click', '#back-to-chart', function(){
        hideMap();
    });
	$(document).on('change', '.map-switcher .show-map', function(e){
//		if ($(this).closest('.map-switcher').is('.no-data')) return false;
		var i = parseInt($(this).val());
		if (!i) i = 0;
		// var lis = $('.legend-place li.russian-stat');
		// var liall = $('.legend-place li').size();
		// var sizelis = $('.legend-place li.russian-stat').size();
		// var diff = liall  - sizelis;
		var li = $('.legend-place li')[i];
		showOnMap(li);
    });
	$(document).on('click', '.legend-place .show_on_map', function(e){
		e.preventDefault();
		showOnMap($(e.target));
    });
	$(document).on('change', '.legend-place .show-on-map', function(e){
		showOnMap($(e.target));
    });
	$(document).on('change', '.hide-map', function(){
        hideMap();
    });
	$(document).on('mouseenter', '.legend-place li', function(e){
		e.stopPropagation();
		var li = $(this);
        li.addClass('hover');
		var bound = {};
		bound.top = li.offset().top - 6;
		bound.left = li.offset().left;
		bound.right = bound.left + parseInt(li.innerWidth()) + 6;
		bound.bottom = bound.top + parseInt(li.innerHeight());
		setTimeout(function () {
			$(document).on('mousemove', {li: li, bound: bound}, closeLegend);
		}, 30);

    });
	$(document).on('click', '#russia-stat', function (e) {
//		e.preventDefault();
		switchRussiaWorld('russia');
	});
	$(document).on('click', '#world-stat', function (e) {
//		e.preventDefault();
		switchRussiaWorld('world');
	});
	$(document).on('click', 'ul.links a', function (e) {
//		e.preventDefault();
		var chart_item = $('.chart-item');

		location.href = $(this).attr('href');
		location.reload();
//		on_hash_change (chart_item);
	});
});

function closeLegend(e) {
	var li = e.data.li;
	var bound = e.data.bound;
	if (e.pageX < bound.left || e.pageX > bound.right || e.pageY < bound.top || e.pageY > bound.bottom) {
		li.removeClass('hover');
		$(document).off('mousemove', closeLegend);
	}
}

var regionOption = function (value, text, selected, h, disabled) {
	if(!selected) selected = false;
	if(!disabled) disabled = false;
//					if(!h) h = 1;
	var ret = ''
	ret += '<option value="' + value + '" ';
	if (selected) ret += 'selected="selected" ';
	if (disabled) ret += 'disabled="disabled" ';
	ret += 'data-h="' + h + '" ';
	ret += '>';
	ret += text;
	ret += '</option>'
	return ret;
}

var statRegionFilter = function (regions, id) {
	id = parseInt(id);
	var region_place = $('.region-selects');
	var level1_options = '';
	var level2_options = '';
	var level3_options = '';

	window.statRegions = regions;

	var parent_ids = [];

	var getParents = function (id) {
		var reg = regions[id]
		if (reg && reg.p != 0) {
//			reg = regions[reg.p]
			parent_ids.push(reg.p);
			getParents(reg.p);
		}
	}

	var level1Options = function () {
		var ret = '';
		ret += '<option data-h="0" value="0"></option>';
		ret += regionOption(-1, 'Вся Россия', id == -1, regions[0].h);
		var lev1 = regions[0].c;
		$.each(lev1, function (i, el) {
			var eli = parseInt(el);
			var okr = regions[el];
			ret += regionOption(el, regions[el].n+' '+regions[el].s, false, 0, true);
			$.each(okr.c, function (i, el) {
				var eli = parseInt(el);
				var obl = regions[el];
				var children_count = okr.c.length;
				var selected = false;
				if (children_count == 1 && regions[0].c.length == 1) selected = true;
				if (eli == id) selected = true;
				if ($.inArray(eli, parent_ids) > -1) selected = true;
				ret += regionOption(el, regions[el].n+' '+regions[el].s, selected, regions[el].h );
			});
		});
		return ret;
	}

	var regionOptions = function (arr) {
		var ret = '';
		if (!arr) return ret;
		if (arr.length > 0) ret += '<option data-h="0"></option>';
		$.each(arr, function (i, el) {
			var eli = parseInt(el);
			var children_count = arr.length;
			var selected = false;
			if (children_count == 1) selected = true;
			if (eli == id) selected = true;
			if ($.inArray(eli, parent_ids) > -1) selected = true;
			ret += regionOption(el, regions[el].n+' '+regions[el].s, selected, regions[el].h );
		});
		return ret;
	}

	if (id) {
		var region = regions[id];
		getParents(id);

		parent_ids = parent_ids.reverse();
		parent_ids.push(id);

		level1_options += level1Options();

		if (parent_ids[1]) {
			level3_options += regionOptions(regions[parent_ids[1]].c);
		}

//		console.log(parent_ids[1], regions[parent_ids[1]], regions);
//		console.log('id', id);
//		console.log('parent_ids', parent_ids);
//		console.log('regions', regions);


	} else {

	level1_options += '<option data-h="0" value="0"></option>';
	level1_options += regionOption(-1, 'Вся Россия', id == -1, regions[0].h);

//	level1_options += level1Options();

	$.each(regions[0].c, function(i, el){

		var level1_children_count = regions[0].c.length;
		var selected = false;
		if (level1_children_count == 1) selected = true;
		if (el == id) selected = true;
		if ($.inArray(el, parent_ids) >= 0) selected = true;

		level1_options += regionOption(el, regions[el].n+' '+regions[el].s, false, 0, true );
		if (regions[0].c.length) {
//			level2_options = '<option data-h="0"></option>';
			var level2_children_count = regions[el].c.length;
			$.each(regions[el].c, function(i, el){
				selected = false;
				if (level2_children_count == 1 && level1_children_count == 1) selected = true;
				if (el == id) selected = true;
				if ($.inArray(el, parent_ids) >= 0) selected = true;
				level1_options += regionOption(el, regions[el].n+' '+regions[el].s, selected, regions[el].h);
//								level2_options += '<option value="' + el + '">' + data.regions[el].n + '</option>'
				if (level2_children_count != 1) return;
				if (regions[el].c.length && id !=0) {
					level3_options = '<option data-h="0"></option>';
					var level3_children_count = regions[el].c.length;
					$.each(regions[el].c, function(i, el){
						selected = false;
						if (el == id) selected = true;
						if ($.inArray(el, parent_ids) >= 0) selected = true;
//						if (level3_children_count == 1) selected = true;
						level3_options += regionOption(el, regions[el].n+' '+regions[el].s, selected, regions[el].h);
					});
				}
			});
		}
	});

	}

	$('#region_id').html(level1_options);
	if (level2_options != '') {
		var level2_select = $('<select name="region_id" class="level2"></select>').html(level2_options);
		region_place.find('select.level2').remove();
		region_place.append(level2_select);
	} else {
		region_place.find('select.level2').remove();
	}
	if (level3_options != '') {
		var level3_select = $('<select name="region_id" class="level3"></select>').html(level3_options);
		region_place.find('select.level3').remove();
		region_place.append(level3_select);
	} else {
		region_place.find('select.level3').remove();
	}
}

var filter = function (url, form_data, sel) {
	if (!sel) sel = false;

	var chart_item = $('.chart-item');
//	var form = sel.closest('form');
	var select_name = '';
	if (sel) select_name = sel.attr('name');
	var opt_selected_val = '';
	if (sel) opt_selected_val = sel.find(':selected').val();

	$.getJSON(url, form_data, function(data) {
		if (data.country_id) data.region_id = data.country_id;
		$.each(data, function(k, v) {
			var _sel = $('select[name=' + k + ']');
			if (_sel.length > 0) {
				var val = _sel.val();
				if (val != '' && k == select_name) {
					if (_sel.find('option').length == 2) {
						if (_sel.is('select[name=commodity_id]')) _sel.find('option:first').text('Выберите другой товар...')
						if (_sel.is('select[name=region_id]')) _sel.find('option:first').text('Выберите другой регион...')
						if (_sel.is('select[name=attribute_id]')) _sel.find('option:first').text('Выберите другой показатель...')
					}
					return;
				}
				_sel.html(v).val(val);
				if (_sel.find('option').length == 2 && val != '') {
					if (_sel.is('select[name=commodity_id]')) _sel.find('option:first').text('Выберите другой товар...')
					if (_sel.is('select[name=region_id]')) _sel.find('option:first').text('Выберите другой регион...')
					if (_sel.is('select[name=attribute_id]')) _sel.find('option:first').text('Выберите другой показатель...')
				}
			}

			if (data.regions) {
				var region_val = '';
				if (sel) {
					if (sel.is('select[name="region_id"]')) {
						region_val = opt_selected_val
						if (opt_selected_val == '') {
							region_val = $('#region_id').find(':selected').val();
						}
					};
				}
//				if (region_val == '') region_val = $('select[name="region_id"]').find(':selected').val();
				if (region_val == '') region_val = getRegionVal();

				statRegionFilter(data.regions, region_val);
			}
		});
		if (data.min_year) {
			chart_item.find('form').find('.dates').html( data.min_year + ' .. ' + data.max_year )
		}
	});
}

$(document).on('change', '.prices select, .stat select', function() {
    var chart_item = $('.chart-item');
	var sel = $(this);
    var form = sel.closest('form');
    var select_name = sel.attr('name');
    form.find('[name=_select]').val( select_name );

	var opt_selected = sel.find(':selected');
//	if (opt_selected.val() && opt_selected.data('h') == 0) return false;

	if (sel.is('select[name="region_id"]')) {
//		if (opt_selected.val() && opt_selected.data('h') == 0) {
//			var region_id = opt_selected.val();
//			if (window.statRegions) {
//				statRegionFilter(window.statRegions, region_id);
//			}
//			return false;
//		}
		if (!opt_selected.val()) {
			sel.next('select[name="region_id"]').remove();
			sel.next('select[name="region_id"]').remove();
		}
	}

	var form_data = form.serialize();

    var url = '/statistics/statisticsFilter';
	if (chart_item.is('.world')) url = '/oldStatistics/statisticsFilter'
    if (sel.closest('.fieldset').is('.prices')) {
        url = '/statistics/pricesFilter';
    }
	if (sel.closest('.fieldset').is('.stat')) {
//		var form_arr = {
//			'commodity_id': $('#commodity_id').val(),
//			'attribute_id': $('#attribute_id').val(),
//			'region_id': $('select[name="region_id"]:last').val()
//		}
//		form_data = $.param(form_arr);
		form_data = statParams();
    }
    if (sel.is('select[name=instrument_id]')) {
        $.getJSON('/statistics/pricesDates', {instrument_id: sel.val()}, function(data) {
            if (data.min_date) {
                form.find('.dates').html( shortDateWithYear(data.min_date) + ' .. ' + shortDateWithYear(data.max_date) )
            };
            if (data.comment) {
                sel.closest('.fieldset').find('.comment').text(data.comment);
            } else {
                sel.closest('.fieldset').find('.comment').text('');
            }
			setPricesFields(data.instrument);
        })
    } else {
		filter(url, form_data, sel);
    }
});

$(document).on('click', '.clone_chart', function(e) {
    e.preventDefault();
    var chart_item = $(this).closest('.chart-item');
    var clone = chart_item.clone();
    //последний изменённый селект не копирует value
    chart_item.find('select').each(function() {
        var sel = $(this);
        clone.find('select[name=' + sel.attr('name') + ']').val( sel.val() )
    })
    chart_item.after(clone);
    init_chart(clone);
    clone.find('.add').click();
});

$(document).on('click', '.chart-item .clear_form', function(e) {
	e.preventDefault();
    var form = $(this).closest('form');
    var fieldset = $(this).closest('fieldset');
    location.hash = ''
    fieldset.find(':input').val('');
    // location.href = '/newStatistics'
    fieldset.find('select:first').val(-1).change()
    // form.find('select[name=region_id] option:eq(1)').attr('selected', 'selected');

});

$(document).on('change', '#normalize', function () {
    refresh_chart($(this).closest('.chart-item'));
});

function set_series_type (chart_item, control) {
    var chart_params = chart_item.data('chart_params');

    var chart = chart_params.chart;
    var chart_data = chart_params.data;
    var options = chart_params.options;
    var raw_data = chart_params.raw_data;

    var ind = chart_item.find('ul.legend-place li').index(control.closest('li'));
    raw_data[ind].series_type = control.val();
    chart_item.data('chart_params', chart_params);
	applyLocationHash(encode_hash(raw_data));
    on_hash_change(chart_item);
}

function parse_url () {
	var res = '';

	$('.page-title').show();

	var url_obj = window.location.pathname.split('/');
	
	var date = new Date();
	date = date_param(date);
	
	if (url_obj[1] == 'statistics'){
		if (url_obj[2] == 'stat'){
			var commodity = 0;
			var country = 0;
			var attribute = 0;
			
			if(url_obj[3] == 'commodity') commodity = url_obj[4];
			if(url_obj[5] == 'country') country = url_obj[6];
			if(url_obj[7] == 'attribute') attribute = url_obj[8];
			
			if(commodity != '0' && country != '0' && attribute != '0') {
				res = 'year&01.01.1960-' + date + '&line:statistics:' + commodity + ':' + country + ':' + attribute;
			}
		} else if (url_obj[2] == 'price') {
			var instrument = 0;
			if(url_obj[3] == 'instrument') instrument = url_obj[4];
			
			if(instrument != '0') {
				res = 'year&01.01.2008-' + date + '&line:prices:' + instrument;
			}
		}
	}
	
	return res;
}


function parse_hash_data () {
    var hash = location.hash.replace('#', '');
    var charts = hash.split('&').slice(1);
    $.each(charts, function (i, el) {
        var param = '';
        var chart_a = el.split(':');
        var series_type = chart_a[0];
        var type = chart_a[1];
        var p = chart_a.slice(2);
        if (type == 'statistics') {
			var is_russia = 1;
			if (p[4] == 'world') is_russia = false;
            var chd = {
                series_type: series_type,
                type: 'statistics',
                commodity_id: p[0],
				region_id: p[1],
				counry_id: p[2],
                attribute_id: p[3]
            }
			if (is_russia) chd['is_russia'] = 1;
            window.charts_hash_data.push(chd);
        } else if (type == 'prices') {
            var chd = {
                series_type: series_type,
                type: 'prices',
                instrument_id: p[0]
            }
            window.charts_hash_data.push(chd);
        }

    });
}

function parse_hash (ret) {
    if (ret == undefined) {
        var res = [];
    } else if (ret == 'obj') {
        var res = {};
    } else {
        var ret = [];
    }
    var hash = location.hash.replace('#', '');
    if (hash == '') {
    	hash = parse_url();
    	if (hash == '') return res;
    }
    var discreteness = hash.split('&')[0];
//    var series_type_a = hash.split('&')[1].split(':');
    var period = hash.split('&')[1].split('-');
    if (period != '') {
        var min_date = period[0].split('.');
        min_date = min_date[2].toString() +'-'+ min_date[1].toString() +'-'+ min_date[0].toString();
		var max_date = '';
		if (period[1] && period[1] != '') {
			max_date = period[1].split('.');
			max_date = max_date[2].toString() +'-'+ max_date[1].toString() +'-'+ max_date[0].toString();
		}
    } else {
        min_date = max_date = '';
    }
    var period_param = 'discrete=' + discreteness + '&market_year_begin='+min_date+'&market_year_end='+max_date+'&date_begin='+min_date+'&date_end='+max_date+'&';

    var charts = hash.split('&').slice(2);

    if(ret == 'obj'){
        res.min_date = period[0];
        res.max_date = period[1];
        res.discreteness = discreteness;
//        res.series_type = series_type;
        res.charts = [];
    }

    $.each(charts, function (i, el) {
        var param = '';
        var chart_a = el.split(':');
        var series_type = chart_a[0]
        var type = chart_a[1];
        var p = chart_a.slice(2);
        var url = '';
        if (type == 'statistics') {
            url = $('.chart-item form').attr('action');
			if (p[4] == 'world') {
				url = '/oldStatistics/statisticsData'
//				p[2] = 'country_id='+p[1]
			};
            p[0] = 'commodity_id='+p[0];
            p[1] = 'region_id='+p[1];
            p[2] = 'country_id='+p[2];
            p[3] = 'attribute_id='+p[3];
        } else if (type == 'prices') {
            url = '/statistics/pricesData';
            p[0] = 'instrument_id='+p[0];
        }
        param=period_param+p.join('&');

        if(ret == 'obj') {
            res.charts.push({url: url, param: param, series_type: series_type});
        } else {
            res.push({url: url, param: param, series_type: series_type});
        }

//        var chart_item = $('.chart-item');
//        get_raw_data (url, res, chart_item)
    });
    return res;
}

function encode_hash (data) {
    var res = '';
    if (data.length == 0) return res;
    res = data[data.length - 1].discreteness + '&';

    var charts_str = '';

    $.each(data, function (i ,el) {
        if(el == undefined) return;
        var type = el.type;
        var series_type = el.series_type;
        var chart_a = [];
		var russia_world = 'world';

		if (el.is_russia) russia_world = 'russia';

        chart_a.push(series_type);
        if (type == 'statistics') {
            if(el.data.length > 0) {
//                if (el.data[0].commodity_id && (el.data[0].region_id || el.data[0].country_id) && el.data[0].attribute_id) {
//                    chart_a.push(type);
//                    chart_a.push(el.data[0].commodity_id);
//					if (!el.data[0].region_id) {
//						if (el.data[0].country_id) el.data[0].region_id = el.data[0].country_id;
//					}
//					if (!el.data[0].country_id) {
//						if (el.data[0].region_id) el.data[0].country_id = el.data[0].region_id;
//					}
//                    if (el.data[0].region_id) {
//						chart_a.push(el.data[0].region_id);
//					} else if (el.region_id) {
//						chart_a.push(el.region_id);
//						el.data[0].country_id = el.region_id;
//					}
//                    if (el.data[0].country_id) chart_a.push(el.data[0].country_id);
//                    chart_a.push(el.data[0].attribute_id);
//                    chart_a.push(russia_world);
//                }
				if (el.commodity_id && (el.region_id || el.country_id) && el.attribute_id) {
                    chart_a.push(type);
                    chart_a.push(el.commodity_id);
					if (!el.region_id) {
						if (el.country_id) el.region_id = el.country_id;
					}
					if (!el.country_id) {
						if (el.region_id) el.country_id = el.region_id;
					}
                    if (el.region_id) {
						chart_a.push(el.region_id);
					}
                    if (el.country_id) chart_a.push(el.country_id);
                    chart_a.push(el.attribute_id);
                    chart_a.push(russia_world);
                }
            } else {
                if (window.charts_hash_data[i]) {
                    chart_a.push(window.charts_hash_data[i].type);
                    chart_a.push(window.charts_hash_data[i].commodity_id);
					if (!window.charts_hash_data[i].region_id) {
						if (window.charts_hash_data[i].country_id) window.charts_hash_data[i].region_id = window.charts_hash_data[i].country_id;
					}
					if (!window.charts_hash_data[i].country_id) {
						if (window.charts_hash_data[i].region_id) window.charts_hash_data[i].country_id = window.charts_hash_data[i].region_id;
					}
                    if (window.charts_hash_data[i].region_id) chart_a.push(window.charts_hash_data[i].region_id);
                    if (window.charts_hash_data[i].country_id) chart_a.push(window.charts_hash_data[i].country_id);
                    chart_a.push(window.charts_hash_data[i].attribute_id);
					russia_world = 'world';
					if (window.charts_hash_data[i].is_russia) russia_world = 'russia';
					chart_a.push(russia_world);
                }
            }
        } else if (type == 'prices') {
            if(el.data.length > 0) {
                if(el.data[0].instrument_id) {
                    chart_a.push(type);
                    chart_a.push(el.data[0].instrument_id);
                }
            } else {
                if (window.charts_hash_data[i]) {
                    chart_a.push(window.charts_hash_data[i].type);
                    chart_a.push(window.charts_hash_data[i].instrument_id);
                }
            }
        }
        if (chart_a.length > 0) {
            charts_str += '&' + chart_a.join(':');
        }
    });

    var min_date_old = parse_hash('obj').min_date;
    if (min_date_old && min_date_old != '') {
        min_date_old = parseDate(min_date_old, 'd.m.y');
    }
    var max_date_old = parse_hash('obj').max_date;
    if (max_date_old && max_date_old != '') {
        max_date_old = parseDate(max_date_old, 'd.m.y');
    }
    var min_date = data[data.length - 1].min_date;
    var max_date = data[data.length - 1].max_date;
    if (!min_date && min_date_old != '') min_date = min_date_old;
    if (!max_date && max_date_old != '') max_date = max_date_old;
    if (min_date) res += date_param(min_date);
    if (max_date) res += '-'+date_param(max_date);

    res += charts_str;

//    if (data.length == 1 && data[0].data.length == 0) res = '';
    return res;
}

//function parseDate(input, format) {
//    format = format || 'yyyy-mm-dd'; // default format
//    var parts = input.match(/(\d+)/g),
//        i = 0, fmt = {};
//    // extract date-part indexes from the format
//    format.replace(/(yyyy|dd|mm)/g, function(part) { fmt[part] = i++; });
//
//    return new Date(parts[fmt['yyyy']], parts[fmt['mm']]-1, parts[fmt['dd']]);
//}


function isValidDate(d) {
    if ( Object.prototype.toString.call(d) !== "[object Date]" )
        return false;
    return !isNaN(d.getTime());
}

function on_hash_change (chart_item, refresh) {
    if (refresh == undefined) refresh = true;
    var harr = parse_hash();
    $.each(harr, function (i, el){

        $.getJSON(el.url, el.param, function(data) {

			hideMap();

            var chart_params = chart_item.data('chart_params');
            data.series_type = el.series_type;
            chart_params.raw_data[i] = data;
            chart_item.data('chart_params', chart_params);
//            if (refresh) {
                refresh_chart(chart_item);
//            }

            get_news(data, i);
			if (data.type == 'prices') {
				setPricesFields(data.instrument);
			} else if (data.type == 'statistics') {
				setStatFields(data);
			}

//			changeDatepickerFormat(data.discreteness);
        });
    });
}

function change_hash (chart_item) {
    window.candlesticks_alert = true;

    var chart_params = chart_item.data('chart_params');

    var chart = chart_params.chart;
    var chart_data = chart_params.data;
    var options = chart_params.options;
    var raw_data = chart_params.raw_data;

    var min_date = parseDate(chart_item.find('input[name="market_year_begin"]').val());
    var max_date = parseDate(chart_item.find('input[name="market_year_end"]').val());
    var discreteness = chart_item.find('#discrete').val();
    var chart_type = chart_item.find('#chart_type').val();

    options.seriesType = chart_type;

    if (raw_data.length == 0) {
        chart_item.data('chart_params', chart_params);
        return;
    }
    $.each(raw_data, function (i, el){

//        if (el.min_date) {
            if (isValidDate(min_date)) {
                el.min_date = min_date;
            }
//        }
//        if (el.max_date) {
            if (isValidDate(max_date)) {
                el.max_date = max_date;
            }
//        }
        el.discreteness = discreteness;
		applyLocationHash(encode_hash(raw_data));
    });
    raw_data = [];
    chart_params.raw_data = [];
    window.news_array = []
    chart_item.data('chart_params', chart_params);

    on_hash_change(chart_item, false);
}

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(init_chart);

var colors = ["#3366cc", "#dc3912", "#ff9900", "#109618", "#990099", "#0099c6", "#dd4477", "#66aa00", "#b82e2e", "#316395", "#994499", "#22aa99", "#aaaa11", "#6633cc", "#e67300", "#8b0707", "#651067", "#329262", "#5574a6", "#3b3eac", "#b77322", "#16d620", "#b91383", "#f4359e", "#9c5935", "#a9c413", "#2a778d", "#668d1c", "#bea413", "#0c5922", "#743411"];
window.news_array = [];
window.charts_hash_data = [];
window.candlesticks_alert = true;


function init_chart(e) {
    var chart_item = e;
    if (chart_item instanceof Event) {
        chart_item = $('.chart-item');
    }

    chart_item.find('.legend-place, .chart_div').empty();
    
    var chart_data = new google.visualization.DataTable();
    chart_data.addColumn('date', 'Дата');
    var chart = new google.visualization.ComboChart(chart_item.find('.chart_div')[0]);
    
//    chart_item.find('.chart_div').css('position', 'static');
    
//    google.visualization.events.addListener(chart, 'ready', function () {
//        $('.chart_div').find('iframe').contents().find('svg > rect').remove();
//    });



    var options = {
        //title: 'Статистика',
        //title: 'Цены',
        colors: colors,
//		pointSize: 2,
		interpolateNulls: true,
        hAxis: {
            viewWindowMode: 'pretty'
        },
        vAxis: {
            textPosition: 'out'
        },
        legend: {
            position: 'none'
        },
		hAxis: {
//			allowContainerBoundaryTextCufoff: true,
			minTextSpacing: 0,
			slantedText: false,
			maxAlternation: 2,
			showTextEvery: 1
		},
		chartArea: {'width': '80%', 'height': '80%'},
        seriesType: 'line',
        series: {}
    };

    var data = {
        data: chart_data,
        chart: chart,
        options: options,
        raw_data: []
    };

    chart_item.data('chart_params', data);

    if (window.location.hash && window.location.hash != '') {
		showChartPlace();
		on_hash_change(chart_item);
        var hash_obj = parse_hash('obj');
        var mnd = hash_obj.min_date;
        var mxd = hash_obj.max_date;
        var discr = hash_obj.discreteness;
//        var s_t = hash_obj.series_type;
        chart_item.find('#date1').val(mnd);
        chart_item.find('#date2').val(mxd);
        if (mnd) mnd = mnd.split('.').reverse().join('-');
        if (mxd) mxd = mxd.split('.').reverse().join('-');
        chart_item.find('#market_year_begin').val(mnd);
        chart_item.find('#market_year_end').val(mxd);
        chart_item.find('#date_begin').val(mnd);
        chart_item.find('#date_end').val(mxd);
        chart_item.find('#discrete option[value='+discr+']').attr('selected', 'true');
		chartItemDiscreteClass(discr);
		changeDatepickerFormat(discr);
		chart_item.removeClass('rw-not-selected').addClass('russia');
		$('#russia-stat').attr('checked', 'checked');
//        chart_item.find('#chart_type option[value='+s_t+']').attr('selected', 'true');
//        options.seriesType = s_t;
        parse_hash_data();
    } else {
    	on_hash_change(chart_item);
		chartItemDiscreteClass('year');
		changeDatepickerFormat('year');
    }
}

function refresh_chart(chart_item) {
	var i,j;
    var chart_params = chart_item.data('chart_params');

    var chart = chart_params.chart;
    var chart_data = chart_params.data;
    var options = chart_params.options;
    var raw_data = chart_params.raw_data;

    if (raw_data.length > 0) {
        $('#chart_type').hide().prev('label').hide();
    } else {
        $('#chart_type').show().prev('label').show();
    }

    chart_data = new google.visualization.DataTable();
//    chart_data.addColumn('date', 'Дата');
    chart_data.addColumn('string', 'Дата');
    chart_params.data = chart_data;
//	options.hAxis = {
////		viewWindowMode: 'explicit',
////		viewWindow: {
////			//max: 180,
////			min: 0
////		},
//		gridlines: {
//			count: 3,
//			color: 'red'
//		}
////		minorGridlines: {
////			count: 3,
////			color: 'green'
////		}
//	}

    
    var min_date = parseDate('2100-01-01');
	var max_date = parseDate('1900-01-01');

    var min_value = Number.MAX_VALUE;
    var max_value = Number.MIN_VALUE;

	window.isRussianStat = false;
    var normalize = false;

    var type = 'Candlestick';
    
    var discreteness = 'year';
    var show_normalize = false;
    var populated_charts_count = 0;
    var points_count = 0;
    var candlesticks_count = 0;
    
    for (i = 0; i < raw_data.length; i++) {
    	var item = raw_data[i];
        if (item == undefined) continue;
	    if (item.type == 'statistics') {
		    type = 'Line';
	    }

        if (item.data.length == 0) {continue;}
        populated_charts_count++;
	    discreteness = item.discreteness;
	    if (!item.min_date || !item.max_date || !item.min_value || !item.max_value) {
	    	var data = item.data;
	    	item.min_date = parseDate('2100-01-01');
	    	item.max_date = parseDate('1900-01-01');
	    	item.min_value = Number.MAX_VALUE;
	    	item.max_value = Number.MIN_VALUE;
	    	item.map = {}
	    	
	    	var value_key = 'value';
	    	if (item.type == 'prices') {
		    	value_key = 'close';
	    	}
	    	
		    for (j = 0; j < data.length; j++) {
		    	var di = data[j];
			    
			    var value = parseInt(di[value_key]);
			    var date = parseDate(di['date']);
			    
			    if (date < item.min_date) {
				    item.min_date = date;
			    }
			    if (date > item.max_date) {
				    item.max_date = date;
			    }
			    
			    if (value < item.min_value) {
				    item.min_value = value;
			    }
			    if (value > item.max_value) {
				    item.max_value = value;
			    }
			    
			    item.map[ date ] = di;
		    }
	    }
	    if (item.min_date < min_date) {
		    min_date = item.min_date;
	    }
	    if (item.max_date > max_date) {
		    max_date = item.max_date;
	    }
//        if (item.type == 'prices') {
        if (item.min_value < min_value) {
            min_value = item.min_value;
        }
        if (item.max_value > max_value) {
            max_value = item.max_value;
        }
//        }

        /*console.log('max_value:'+max_value, 'min_value:'+min_value, 'item.max_value:'+item.max_value, 'item.min_value:'+item.min_value);
        console.log((max_value - min_value)/(item.max_value - item.min_value));
        if((max_value - min_value)/(item.max_value - item.min_value) > 1.4 || (max_value - min_value)/(item.max_value - item.min_value) < 0) {
            show_normalize = show_normalize || true;
        }*/
    }

    if (populated_charts_count > 1) {
	    $('div.normalize').show();
    } else {
	    $('div.normalize').hide();
//        $('#normalize').removeAttr('checked');
    }
//	if (populated_charts_count > 0) {
//		$('.map-switcher').show();
//	} else {
//		$('.map-switcher').hide();
//	}

    if ($('#normalize').is(':checked') && populated_charts_count > 1) {
        normalize = true;
        options.vAxis.textPosition = 'none';
    } else {
        normalize = false;
        options.vAxis.textPosition = 'out';
    }
    
    var next_functions = {
	    day: function (date) {
	    	date = new Date( date.getTime() + 27 * 3600 * 1000 );
	    	date.setHours(0);
		    return date;
	    },
	    month: function (date) {
	    	date = new Date( date.getTime() + 32 * 24 * 3600 * 1000 );
	    	date.setDate(1);
	    	date.setHours(0);
		    return date;
	    },
	    week: function (date) {
	    	date = new Date( date.getTime() + 7 * 24 * 3600 * 1000 );
	    	date.setHours(0);
		    return date;
	    },
	    year: function (date) {
	    	date = new Date( date.getTime() );
	    	date.setFullYear(date.getFullYear() + 1);
	    	date.setHours(0);
	    	date.setDate(1);
		    return date;
	    }
	}
    
    next_date = next_functions[ discreteness ];
    
    row_indexes = {};

    i = 0;
    for (var date = min_date; date <= max_date; date = next_date(date)) {
    	row_indexes[date] = i++;
//	    chart_data.addRow([date]);
//	    chart_data.addRow([dateSQL(date)]);
	    chart_data.addRow([getDateForTooltip(date).toString()]);

    }

	var haxis_step = Math.ceil(i / 8);
	if (haxis_step>0) {
		options.hAxis.showTextEvery = haxis_step;
		options.hAxis.gridlines={
			count: Math.floor(i/haxis_step)
		}
	}

    for (i = 0; i < raw_data.length; i++) {
	    var item = raw_data[i];
        if (item == undefined) continue;
//	    chart_data.addColumn('number', item.name);
	    chart_data.addColumn('number');


        if (!item.series_type) item.series_type = options.seriesType;
        var series_type = item.series_type;
        options.series[i] = {type: series_type};

	    if (item.series_type == 'candlesticks') {
            if (item.data.length !=0 && item.data[0].close && item.data[0].open && item.data[0].low && item.data[0].high) {
                chart_data.addColumn('number');
                chart_data.addColumn('number');
                chart_data.addColumn('number');
                options.series[i] = {type: 'candlesticks'};
                series_type = 'candlesticks';
                candlesticks_count++;
            } else {
                options.series[i] = {type: 'line'};
                item.series_type = 'line';
            }
        }
	    var value_key = 'value';
    	if (item.type == 'prices') {
	    	value_key = 'close';
    	}

        if (series_type == 'candlesticks') {
            points_count += item.data.length*4;
            if (points_count > 690 && candlesticks_count > 1) {
                raw_data.splice(i, 1);
                chart_item.data('chart_params', chart_params);
                if (populated_charts_count == 2) $('div.normalize').hide();
                if (window.candlesticks_alert) alert('Попробуйте понизить дискретность, задать меньший период или выбрать другой тип графика.');
                window.candlesticks_alert = false;
                return;
            }
        } else {
//            points_count += item.data.length;
        }


	    
	    var columns_count = chart_data.getNumberOfColumns();
	    var data = item.data;


		var isInt = function(n) {
			return typeof n === 'number' && n % 1 == 0;
		}

		chart_data.addColumn({type:'string',role:'tooltip'});
	    for (j = 0; j < data.length; j++) {
	    	var di = data[j];
	    	
	    	var row_index = row_indexes[ parseDate(di.date) ];
//	    	var row_index = row_indexes[ di.date ];


//			chart_data.setCell(row_index, 0, getDateForTooltip(di.date).toString());

	    	if (typeof row_index == 'undefined') {
		    	continue;
	    	}



            function nnormalize (val) {
                var ret = val;
                if (normalize) {
                    ret = (max_value - min_value)/(item.max_value - item.min_value)*(ret-item.min_value)+min_value;
                }
                return ret;
            }

		    if (series_type == 'candlesticks' && options.seriesType != 'Scatter') {
		    	chart_data.setCell(row_index, columns_count - 4, parseFloat(nnormalize(di.low)), di.low);
		    	chart_data.setCell(row_index, columns_count - 3, parseFloat(nnormalize(di.open)), di.open);
		    	chart_data.setCell(row_index, columns_count - 2, parseFloat(nnormalize(di.close)), di.close);
		    	chart_data.setCell(row_index, columns_count - 1, parseFloat(nnormalize(di.high)), di.high);

		    } else {
                var di_v = di[value_key];
			    chart_data.setCell(row_index, columns_count - 1, parseFloat(nnormalize(di_v)), di_v);

		    }
			chart_data.setCell(row_index, columns_count, getDateForTooltip(di.date) + '\n' + getNameForTooltip(item) + ': ' + di_v);
		}
    }
    
    var legend_place = chart_item.find('.legend-place').empty();
    
    for (var i = 0; i < raw_data.length; i++) {
//    for (var i = 0; i < 3; i++) {
        if (raw_data[i] == undefined) continue;

		var params = {
			commodity_id: raw_data[i].commodity_id,
			region_id: raw_data[i].region_id,
			attribute_id: raw_data[i].attribute_id,
			discrete: raw_data[i].discreteness,
			market_year_begin: raw_data[i].market_year_begin,
			market_year_end: raw_data[i].market_year_end
		};

		if (raw_data[i].is_russia && raw_data[i].data.length > 0) {

			if (!window.isRussianStat) {
				window.isRussianStat = true;


//				if (!window.charts_hash_data[i].map_info_checked) {
					getMapData(params, raw_data[i], i, true, true);
//				}
			} else {

//				if(!window.charts_hash_data[i].map_info_checked) {
					getMapData(params, raw_data[i], i, true, false);
//				}
			}

//			window.charts_hash_data[i].map_info_checked = true;
		}

        if (i < 3) setItemLegend(raw_data[i], i);

		setPeriodFields(raw_data[i]);
    }

	if (window.isRussianStat) {
		$('.map-switcher').show();
	} else {
		$('.map-switcher').hide();
	}

    chart_item.find('.chart_div').empty();
    if (options.seriesType == 'Scatter') {
        chart = new google.visualization.ScatterChart(chart_item.find('.chart_div')[0]);
    } else {
        chart = new google.visualization.ComboChart(chart_item.find('.chart_div')[0]);
    }
//    chart_item.find('.chart_div').css('position', 'static');
    chart_params.chart = chart;
    
    if (raw_data.length <= 0) {
        //chart_item.hide();
		hideChartPlace();
    } else {
        chart_item.show();
        chart.draw(chart_data, options);
        google.visualization.events.addListener(chart, 'onmouseover', function (e) {
            Helpers.debounce(add_news(e, chart_item), 500);
        });
    }
    chart_item.data('chart_params', chart_params);
	applyLocationHash(encode_hash(raw_data));
}

function remove_chart (e) {
    e.preventDefault();
    if (confirm('Удалить?')) {
		hideMap();
        var chart_item = $(this).closest('.chart-item');
        var chart_params = chart_item.data('chart_params');

        var chart = chart_params.chart;
        var chart_data = chart_params.data;
        var options = chart_params.options;
        var raw_data = chart_params.raw_data;

        var li = $(this).closest('li');
        var ind = $('ul.legend-place li').index(li[0]);
        raw_data.splice(ind, 1);
        window.news_array.splice(ind, 1);
        window.charts_hash_data.splice(ind, 1);
        chart_item.data('chart_params', chart_params);

//		var map_switcher = $('.map-switcher');
//		var map_i = map_switcher.find('.show-map').val();
//		if (map_i > 0) map_switcher.find('.show-map').val(map_i - 1);

        refresh_chart(chart_item);
        add_news({mode: 'del', i: ind}, false);
    }
}

function date_param (d) {
    d = new Date(d);
    var rmonth = d.getMonth()+1;
    if (rmonth > 0 && rmonth < 10) {
        rmonth = '0' + rmonth.toString();
    }
    var rdate = d.getDate();
    if (rdate > 0 && rdate < 10) {
        rdate = '0' + rdate.toString();
    }
    var r = rdate + '.'+rmonth+'.'+ d.getFullYear();
    return r;
}

function add_news (e, chart_item) {
    if (e.mode && e.mode == 'del') {
        if ($('.news').data('chart_index') == e.i) {
            $('.news').hide().empty().data('chart_index', 'false');
        }
        return;
    }

    var chart_params = chart_item.data('chart_params');

    var chart = chart_params.chart;
    var chart_data = chart_params.data;
    var options = chart_params.options;
    var raw_data = chart_params.raw_data;

    var accord = {};
    var accord_count = 0;
    $.each(raw_data, function (i, el) {
        accord[accord_count] = i;
        accord_count = accord_count+2;
        if (el.series_type == 'candlesticks') accord_count = accord_count+4;

    });

    var ci = e.column-1;

    var discreteness = raw_data[accord[ci]].discreteness;

//    var date = chart_data.getValue(e.row, 0);

    var date = chart_data.getValue(e.row, e.column-1) //.split('\n')[0];
	if (date) {
		var _date = date.split('.');
		var begin_date = parseDate(date, 'dd.mm.yy');
		var end_date = parseDate(date, 'dd.mm.yy');
	} 
		


    if (discreteness == 'year') {
		begin_date = new Date();
		begin_date.setFullYear(date);
		end_date = new Date(begin_date);
        end_date.setFullYear(begin_date.getFullYear()+1);
    } else if (discreteness == 'month') {
		begin_date = new Date();
		begin_date.setFullYear(_date[1]);
		begin_date.setMonth(_date[0]);
		end_date = new Date(begin_date);
        end_date.setMonth(begin_date.getMonth()+1);
    } else if (discreteness == 'week') {
        end_date.setDate(begin_date.getDate()+7);
    } else {
        end_date.setDate(begin_date.getDate()+1);
    }

    var n = window.news_array[accord[ci]];

    var nc =0;
    var res = '';
    if (n && n.items && n.items.length > 0) {
        $.each(n.items, function (i, el) {
            var n_date = new Date(Date.parse(el.date));
            if(nc>4) return;
            if (n_date >= begin_date && n_date <= end_date) {
                res += '<li><div><a href="/news/' + el.id + '.html">' + el.title + '</a></div></li>';
                nc++;
            }
        });
    }
    if (nc>0) {
        var tags_param = n.choosed_tags.join('&tags=');
        res += '<li class="more"><div><a href="/timeLine/friendsNews#tags='+tags_param+'&begin_date='+date_param(begin_date)+'&end_date='+date_param(end_date)+'">' + 'Еще новости...' + '</a></div></li>';
    }
    $('.news').html(res);
    if (nc>0) {
		$('.news-wr').show();
        $('.news').fadeIn(200).data('chart_index', e.column-1);
    } else {
		$('.news-wr').hide();
        $('.news').hide().data('chart_index', 'false');
    }
}

function get_news (data, index) {
    var news_url = '/news?filter=1&json=1&importance=';
    news_url += data.discreteness;
    var begin_date = data.min_date;
    var end_date = data.max_date;
    if (begin_date) {
        news_url += '&begin_date=' + date_param(begin_date);
    }
    if (end_date) {
        news_url += '&end_date=' + date_param(end_date);
    }
    var tags = data.tags;
    if (tags && tags.length > 0) {
        $.each(tags, function (i, el) {
            news_url += '&tags[]=' + el;
        });
    }

    $.get(news_url, function (news) {
        news = JSON.parse(news);
        window.news_array[index] = news;
    });
}

function get_raw_data (url, params, chart_item, refresh) {
    if (refresh == undefined) refresh = true;

    $.getJSON(url, params, function(data) {
	    if (!data.data) {
		    return
	    }

        var chart_params = chart_item.data('chart_params');
//        if (data.data.length == 0) {
//            alert('Нет данных за выбранный период с указанной дискретностью');
//        } else {
        chart_params.raw_data.push(data);
//        }

        chart_item.data('chart_params', chart_params);
        if (refresh) {
            refresh_chart(chart_item);
        }


        get_news(data, chart_params.raw_data.length-1);

//		changeDatepickerFormat(data.discreteness);
    });
}

var discreteLabel = function (d) {
	var l = {
		year: t('год'),
		month: t('месяц'),
		week: t('неделя'),
		day: t('день')
	};
	return l[d];
}

var legendSeriesSelect = function (item) {
	var ret = '';
	ret += '<select class="series_type"><option value="line">Линии</option>';
	if (item.type == 'prices' )ret += '<option value="candlesticks">Свечи</option>';
	ret += '<option value="bars">Гистограмма</option><option value="area">Области</option></select>';
	ret = $(ret).val(item.series_type);
	return ret;
}

var legendPeriod = function (date_begin, date_end) {
	var ret = '';
	ret += ' <i class="no-wrap">за ' + getDateForTooltip(date_begin) + '—' + getDateForTooltip(date_end) + '</i>';
	return ret;
}

var setItemLegend = function (item, index) {
	var legend_place = $('.legend-place');
	var item_text = item.name;
	var item_comment = item.comment;
	if (item.data.length == 0) {
		item_text += t(' Нет данных');
	}
	if (item.type == 'prices') {
		if (item.date_begin != '' && item.date_end != '') {
			item_text += legendPeriod(item.date_begin, item.date_end);
		} else {
			if (item.min_date && item.max_date) {
				item_text += legendPeriod(item.min_date, item.max_date);
			}
		}
	}
	if (item.type == 'statistics') {
		if (item.market_year_begin != '' && item.market_year_end != '') {
			item_text += legendPeriod(item.market_year_begin, item.market_year_end);
		} else {
			if (item.min_date && item.max_date) {
				item_text += legendPeriod(item.min_date, item.max_date);
			}
		}
	}

	if (item.data.length == 0) {
		item_text += t(' с периодичностью ') + '<b>' + discreteLabel(item.discreteness) + '</b>';
	}

	var li = $('<li></li>').append(
		$('<span></span>').css('background-color', colors[index])
	).append(
		$('<div></div>').html(item_text).append(
			$('<em></em>').text(item_comment)
		)
	).append(
		$('<label>Тип графика</label>').append(
			legendSeriesSelect(item)
		)
	).append(
		$('<a href="#" class="close"></a>').click(remove_chart)
	).appendTo(legend_place);
	if (item.data.length == 0) {
		li.addClass('no-data');
	}
	if (item.type == 'statistics') {
		li.addClass('stat-legend');
		if (item.is_russia && item.data.length > 0) {
			window.isRussianStat = true;
			li.addClass('russian-stat')
			if (window.charts_hash_data[index].map_info_checked) {
				if (!window.charts_hash_data[index].no_map_info) {
					li.append(
						$('<a href="#" class="show_on_map ajax">Показать на карте</a>')
					);
				}
			} else {
				li.append(
					$('<a href="#" class="show_on_map ajax">Показать на карте</a>')
				);
			}
		}
	}
}

var setPeriodFields = function (item) {
	var min_date = '';
	var max_date = '';
	if (item.type == 'prices') {
		if (item.date_begin != '' && item.date_end != '') {
			min_date = item.date_begin;
			max_date = item.date_end;
		} else {
			if (item.min_date && item.max_date) {
				min_date = item.min_date;
				max_date = item.max_date;
			}
		}
	}
	if (item.type == 'statistics') {
		if (item.market_year_begin != '' && item.market_year_end != '') {
			min_date = item.market_year_begin;
			max_date = item.market_year_end;
		} else {
			if (item.min_date && item.max_date) {
				min_date = item.min_date;
				max_date = item.max_date;
			}
		}
	}

	if (min_date) {
//		$('#date1').datepicker('setDate', min_date);
		$('#date1').val(getDateForTooltip(min_date));
		if (isValidDate(min_date)) {
			$('#market_year_begin').val(min_date.mformat('Y-m-d'));
		} else {
			$('#market_year_begin').val(min_date);
		}
	}
	if (max_date) {
		$('#date2').val(getDateForTooltip(max_date));
		if (isValidDate(max_date)) {
			$('#market_year_end').val(max_date.mformat('Y-m-d'));
		} else {
			$('#market_year_end').val(max_date);
		}
	}
}

var setPricesFields = function(instrument) {
	if (instrument) {
		var selects = $('.prices select').not('#instrument_id');
		var discrete_sel = $('#discrete');

		if (window.charts_hash_data.length == 0) {
			if (instrument['default_period'] == 'ежедневно') {
				discrete_sel.find('option').removeAttr('selected').filter(function () {
					return $(this).val() == 'day';
				}).attr('selected', 'selected');
//				discrete_sel.change();
				changeDatepickerFormat('day');
				chartItemDiscreteClass('day');
			}
		}
		var i_id = $('#instrument_id');
		selects.each(function () {
			var name = $(this).attr('name');
			var val = instrument[name];
			if (!val) return;
			val = val.toLowerCase();
			$(this).find('option').each(function () {
				var opt_val = $(this).val();
				if (opt_val == val) $(this).attr('selected', 'selected');
			});
		});
		i_id.find('option[value=' + instrument.id + ']').attr('selected', 'selected');

		if (instrument['comment']) {
			$('.prices .comment').show().text(instrument['.comment']);
		}
	}
}

var setStatFields = function (data) {
	if (data) {
		var selects = $('#commodity_id, #attribute_id');
		selects.each(function () {
			var name = $(this).attr('name');
			var val = data[name];
			if (!val) return;
	//		val = val.toLowerCase();
			$(this).find('option').each(function () {
				var opt_val = $(this).val();
				if (opt_val == val) $(this).attr('selected', 'selected');
			});
		});
		var region_id = data['region_id'];
		if (data.is_russia) {
			var params = {
				attribute_id: data.attribute_id,
				commodity_id: data.commodity_id,
				region_id: data.region_id,
				country_id: data.region_id
			};
			$.getJSON('/statistics/statisticsFilter', params, function(data){
				statRegionFilter(data.regions, region_id);
			});
		}
//		$('#region_id').trigger('change');
	}
}

var changeDatepickerFormat = function(discrete) {
	var date1 = parseDate($('input[name="market_year_begin"]').val(), 'yy.mm.dd');
	var date2 = parseDate($('input[name="market_year_end"]').val(), 'yy.mm.dd');
	if (discrete == 'year') {
		$( "#date2" ).datepicker( "option", "dateFormat", 'yy');
		$( "#date1" ).datepicker( "option", "dateFormat", 'yy');
	} else if (discrete == 'month') {
		$( "#date2" ).datepicker( "option", "dateFormat", 'mm.yy');
		$( "#date1" ).datepicker( "option", "dateFormat", 'mm.yy');
	} else {
		$( "#date2" ).datepicker( "option", "dateFormat", 'dd.mm.yy');
		$( "#date1" ).datepicker( "option", "dateFormat", 'dd.mm.yy');
	}
	if (date1 && isValidDate(date1)) $( "#date1" ).datepicker( "setDate", date1);
	if (date2 && isValidDate(date2)) $( "#date2" ).datepicker( "setDate", date2);
}

var chartItemDiscreteClass = function (discr) {
	var chart_item = $('.chart-item');
	chart_item.removeClass('discrete-year');
	chart_item.removeClass('discrete-month');
	$('body').removeClass('discrete-year');
	$('body').removeClass('discrete-month');
	if (discr == 'year' || discr == 'month') {
		chart_item.addClass('discrete-'+discr);
		$('body').addClass('discrete-'+discr);
	}
}

var getNameForTooltip = function (item) {
	var ret = '';
	if (item.type == 'statistics') {
		if (item.region_name) ret =  item.region_name + ', ';
		ret += item.commodity_name + ',\n' + item.attribute_name + ' ' + item.units_name;
	}
	if (item.type == 'prices') {
		ret = item.instrument_name + '\n' + item.instrument_currency;
	}
	return ret;
}

var getDateForTooltip = function (date) {
	var ret = date;
	var _date = date;
	if (!isValidDate(date)) _date = parseDate(date, 'yy-mm-dd');
	var chart_item = $('.chart-item')
	ret = date_param(date);
	if (chart_item.is('.discrete-year')) ret = _date.getFullYear();
	if (chart_item.is('.discrete-month')) {
		var mnt = _date.getMonth() + 1;
		if (mnt<10) mnt = '0' + mnt;
		ret = mnt + '.' + _date.getFullYear();
	}
	return $.trim(ret);
}

var getMapInfo = function (data_item) {
	var map_info = data_item.name;
	if (data_item.min_date && data_item.max_date) {
		map_info += ' за ' + getDateForTooltip(data_item.min_date) + '—' + getDateForTooltip(data_item.max_date);
	}
	return map_info;
}

var statParams = function () {
	var region_id = '';
	if ($('select[name="region_id"]:last').find(':selected').data('h') == 1) region_id = $('select[name="region_id"]:last').val();
	var form_arr = {
		'commodity_id': $('#commodity_id').val(),
		'attribute_id': $('#attribute_id').val(),
		'region_id': region_id
	}
	var form_data = $.param(form_arr);
	return form_data;
}

var switchRussiaWorld = function (mode, form_data) {
	var chart_item = $('.chart-item');
//	var mode = 'russia';
	chart_item.removeClass('rw-not-selected');
	if (mode == 'world') {
		chart_item.removeClass('russia').addClass('world');
	} else if (mode == 'russia') {
		chart_item.removeClass('world').addClass('russia');
	}

	var url = '/statistics/statisticsFilter';
	if (mode == 'world') {
		url = '/oldStatistics/statisticsFilter'
		$('select[name="region_id"]').not('#region_id').remove();
	}
	if(!form_data) {
		form_data = {
			'commodity_id': '',
			'attribute_id': '',
			'region_id': ''
		};
	}
	form_data = $.param(form_data);
	$('.stat select').empty();

	filter(url, form_data);
}

var showChartPlace = function() {
	$('.chart-container').show();
	$('.info').hide();
}

var hideChartPlace = function() {
	$('.chart-container').hide();
	$('.info').show();
}

var applyLocationHash = function (hash) {
	if (hash == '') {
		var scr = document.body.scrollTop;
		location.hash = hash;
		document.body.scrollTop = scr;
		var top = $('.chart-item').offset().top
		if (scr > top) $('html, body').animate({scrollTop: top}, 400);
	} else {
		location.hash = hash;
	}
}

var setMapInfo = function (map_data, chart_data, ind) {
	var map_info = chart_data.name;
	if (map_data.date != '') map_info += ' за ' + getDateForTooltip(map_data.date);

	var map_switcher = $('.map-switcher');
	var show_map_inp = map_switcher.find('input.show-map');

	map_switcher.removeClass('no-data');
	show_map_inp.removeAttr('disabled');

	if (map_data.data.length == 0 && parseInt(map_data.region_id) != -1) {
		map_switcher.addClass('no-data');
		show_map_inp.attr('disabled', 'disabled');
		map_info += ' <br /><b>Данные для детализации на карте недоступны</b>';
	}

	if (ind) show_map_inp.val(ind);

	$('#show-map-info').html(map_info);
}

var getMapData = function (params, chart_data, ind, info_only, set_map_info) {
	if (!info_only) info_only = false;
	if (!set_map_info) set_map_info = false;

	$.ajax({
		url: '/statistics/statisticsMapData',
		dataType: 'json',
		data: params,
		success: function (data) {
			roundData(data.data, 3);
			if (!info_only) getRegion(data.region_id, data.data, chart_data);
			var map_info = chart_data.name;
			if (data.date != '') map_info += ' за ' + getDateForTooltip(data.date);

			var map_switcher = $('.map-switcher');
			var show_map_inp = map_switcher.find('input.show-map');
//			if (set_map_info) {
//				map_switcher.removeClass('no-data');
//				show_map_inp.removeAttr('disabled');
//			}
			if (data.data.length == 0 && parseInt(data.region_id) != -1) {
//				if (set_map_info) {
//					map_switcher.addClass('no-data');
//					show_map_inp.attr('disabled', 'disabled');
//					map_info += ' <br /><b>Данные для детализации на карте недоступны</b>';
//				}
//				if (ind) {
				var li = $('.legend-place li')[ind];
				$(li).find('.show_on_map').hide();
//				}
				window.charts_hash_data[ind].no_map_info = true;
			}

			if (set_map_info) {
//				if (ind) show_map_inp.val(ind);
//
//				$('#show-map-info').html(map_info);

				setMapInfo(data, chart_data, ind);
			}
		}
	});
}

var _iter = function (points) {
	var min = [255,255]
	var max = [0,0]

	$.each(points, function (i, pp) {

		$.each(pp, function (i, p) {

			var p0 = p[0]
			var p1 = p[1]

			if (p0 < min[0]) min[0] = p0;
			if (p1 < min[1]) min[1] = p1;
			if (p0 > max[0]) max[0] = p0;
			if (p1 > max[1]) max[1] = p1;
		});
	});

	return [min, max];
}

var getRegion = function (id, map_data, chart_data) {
	$.ajax({
		url: '/geodata/' + id + '.js',
		dataType: 'json',
		success: function (data) {


			var p = [];
			$.each(data.children, function (i, el){
				p.push(el.points);
				drawRegion(el.points, map_data[i], chart_data);
			});
			p = _.compact(p);
			p = _.flatten(p, true);
			var bounds = _iter(p);
			var cz = ymaps.util.bounds.getCenterAndZoom(bounds, [500, 300]);
			yamap.setCenter(cz.center, cz.zoom,{ duration: 200});

		}
	});
}

var drawRegion = function (points, region_data, chart_data) {
	if (!region_data) region_data = {
		color: '#aaaaaa',
		value: '',
		region_name: ''
	}
	var hint_content = '';
	if (region_data.value != '') {
		if (region_data.name_for_map) {
			hint_content = region_data.name_for_map + ': ' + region_data.value;
		}
	} else {
		if (region_data.name_for_map) {
			hint_content = region_data.name_for_map;
		}
	}
	var strokeColor = region_data.color + '33';
	var obj = new ymaps.Polygon(points, { hintContent: hint_content }, {strokeWidth: 1, strokeColor: strokeColor, fillColor: region_data.color + '66'});
	yamap.geoObjects.add(obj);
//	cz = ymaps.util.bounds.getCenterAndZoom(obj.geometry.getBounds(), [500, 300]);
//	map.setCenter(cz.center, cz.zoom,{ duration: 400});
}

function mapInit (cds) {
	window.yamap = new ymaps.Map("map", {
			center: [55.76, 37.64],
			zoom: 7

		}),
//		geometry = {
//			type: 'Polygon',
//			coordinates: cds
//		},
		myOptions = {
			strokeWidth: 1,
			strokeColor: '#00000066',
			fillColor: '#99000066',
			draggable: false      // объект можно перемещать, зажав левую кнопку мыши
		};

	yamap.controls.add('zoomControl');
//	map.behaviors.enable('scrollZoom');

}

var showOnMap = function (trigger) {
//	e.preventDefault();

	trigger = $(trigger);

	var chart_item = trigger.closest('.chart-item');
	var chart_params = chart_item.data('chart_params');

	var chart = chart_params.chart;
	var chart_data = chart_params.data;
	var options = chart_params.options;
	var raw_data = chart_params.raw_data;

	var li = trigger.closest('li');
	var ind = $('ul.legend-place li').index(li[0]);
	var map_switcher = $('.map-switcher');
	map_switcher.find('.show-map').val(ind);

	if (raw_data[ind].type == 'statistics') {

		showMap()

		if (!window.yamap) {
			mapInit();
		}
		yamap.geoObjects.each(function (obj) {
			yamap.geoObjects.remove(obj);
		});

//		$('#show-map-info').text(getMapInfo(raw_data[ind]));

		var market_year_begin = '';
		var market_year_end = '';

		if (isValidDate(raw_data[ind].min_date)) market_year_begin = raw_data[ind].min_date.mformat('Y-m-d');
		if (isValidDate(raw_data[ind].max_date)) market_year_end = raw_data[ind].max_date.mformat('Y-m-d');

		var region_id = '';
		var commodity_id = '';
		var attribute_id = '';
		if (raw_data[ind].data.length > 0) {
			region_id = raw_data[ind].region_id;
			commodity_id = raw_data[ind].data[0].commodity_id;
			attribute_id = raw_data[ind].data[0].attribute_id;
		} else {
			region_id = raw_data[ind].region_id;
			commodity_id = raw_data[ind].commodity_id;
			attribute_id = raw_data[ind].attribute_id;
		}

		var params = {
			commodity_id: commodity_id,
			region_id: region_id,
			attribute_id: attribute_id,
			discrete: raw_data[ind].discreteness,
			market_year_begin: market_year_begin,
			market_year_end: market_year_end
		};

//		var first_lev_ids = ["1011355","1011360","1011358","1011361","1011357","1011354","1011359","1011356"];
		var first_lev_ids = firstLevelIds;

		if (parseInt(region_id) == -1) {

			yamap.setCenter([64.92397224470625, 98.10875], 2, { duration: 200});

			$.ajax({
					url: '/statistics/statisticsMapData',
					dataType: 'json',
					data: params,
					success: function (data) {
						roundData(data.data, 3)

						setMapInfo(data, raw_data[ind], ind);

						var rd = data.data;

						$.each(first_lev_ids, function (i, el) {
//							var map_data = rd[el];

							$.ajax({
								url: '/geodata/' + el + '.js',
								dataType: 'json',
								success: function (fo_data) {

//									var p = [];
									if (fo_data.children) {
										$.each(fo_data.children, function (i, el){
	//										p.push(el.points);
											drawRegion(el.points, rd[el.id], chart_data);
										});
									}

								}
							});
						});
					}
			});

//			$.each(first_lev_ids, function (i, el) {
//				params.region_id = el;
//				$.ajax({
//					url: '/newStatistics/statisticsMapData',
//					dataType: 'json',
//					data: params,
//					success: function (data) {
//						var map_data = data.data
//
//						setMapInfo(data, raw_data[ind], ind);
//
//						$.ajax({
//							url: '/geodata/' + el + '.js',
//							dataType: 'json',
//							success: function (r_data) {
//
//								var p = [];
//								$.each(r_data.children, function (i, el){
//									p.push(el.points);
//									drawRegion(el.points, map_data[i], chart_data);
//								});
//
//							}
//						});
//					}
//				});
//
//			});
		} else {
			getMapData(params, raw_data[ind], ind, false, true);
		}
	}

}

var roundData = function(data, precision) {
	$.each(data, function(index, item) {
		item.value = parseFloat(item.value).toFixed(precision)
	})
}

var showMap = function () {
	$('.map-wr').show();
	$('.chart-container').addClass('hidden')
	$('.chart_div').hide();
	$('.normalize').addClass('hidden');
	$('.map-switcher input.show-map').attr('checked', 'checked');
}

var hideMap = function () {
	$('.map-wr').hide();
	$('.chart-container').removeClass('hidden')
	$('.chart_div').show();
	$('.normalize').removeClass('hidden');
//	$('legend-place input.hide-map').attr('checked', 'checked');
//	$('legend-place input.show-on-map').removeAttr('checked');
	$('.map-switcher input.hide-map').attr('checked', 'checked');
}

var dateSQL = function (date_obj) {
	var year = date_obj.getFullYear();
	var month = date_obj.getMonth();
	var date = date_obj.getDate();
	return year + '-' + month + '-' + date;
}

var getRegionVal = function () {
	var r = '';
	var selects = $('select[name="region_id"]');
	selects.each(function (i, el) {
		var v = $(el).find('option:selected').val();
		if (v && v != '') r = v;
	});
	return r;
}

$(document).on('click', '#add_stat_chart, #add_price_chart', function(e) {
	e.preventDefault();
	var $this = $(this);
	var form = $(this).closest('form');

	var chart_item = $this.closest('.chart-item');

	$('.page-title').hide();
	showChartPlace();
	hideMap();

	window.candlesticks_alert = true;

	var url = form.attr('action');
	if (chart_item.is('.world')) url = '/oldStatistics/statisticsData';
	if ($this.is('#add_price_chart')) {
		if (!$('#instrument_id').val()) {
			alert(t('Выберите инструмент'))
			return
		}
		url = '/statistics/pricesData';
		if (chart_item.is('.world')) url = '/oldStatistics/pricesData';
		var chd = {
			type: 'prices',
			instrument_id: $('#instrument_id').val()
		}
		window.charts_hash_data.push(chd);

	} else {
		if (!$('#commodity_id').val() || !$('#attribute_id').val()) {
			alert(t('Выберите товар, регион и показатель'));
			return;
		}
		var chd = {
			type: 'statistics',
			commodity_id: $('#commodity_id').val(),
			region_id: getRegionVal(),
			country_id: $('#region_id').val(),
			attribute_id: $('#attribute_id').val()
		}
		if (chart_item.is('.russia')) chd['is_russia'] = 1;

		window.charts_hash_data.push(chd);
	}

	$('#date_begin').val($('#market_year_begin').val());
	$('#date_end').val($('#market_year_end').val());

	var _form_data = form.serializeArray();
	var form_data = [];
	var region_val = getRegionVal();
	$.each(_form_data, function(i, el){
		if (el && el['name'] != 'region_id') {
			form_data.push(el);
		}
		// if (!$this.is('#add_price_chart')) {
		// 	var excludeArr = ['location', 'commoduty', 'terms', 'instrument_id', 'prices_url', 'exchange' ];
		// 	$.each(excludeArr, function(index, item) {
		// 		if (el['name'] == item) {
		// 			el.value = ''
		// 		}
		// 	})
		// }
	});
	form_data.push({
		name: 'region_id',
		value: region_val
	});
	form_data.push({
		name: 'country_id',
		value: $('#region_id').val()
	})
	var params = $.param(form_data);
//	var params = form.serialize();
	get_raw_data(url, params, chart_item);
});
