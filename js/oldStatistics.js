$(function () {
	
    $('.period #date1').datepicker({
        changeMonth: true,
        changeYear: true,
        altField: '#market_year_begin',
        altFormat: "yy-mm-dd"
    });
    $('.period #date2').datepicker({
        changeMonth: true,
        changeYear: true,
        altField: '#market_year_end',
        altFormat: "yy-mm-dd"
    });
});

$(function () {
    $.getJSON('/oldStatistics/pricesFilter', function(data) {
        $.each(data, function(k, v) {
            var _sel = $('select[name=' + k + ']');
            if (_sel.length > 0) {
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
        change_hash($(this).closest('.chart-item'));
    });
    $('input[name="date2"]').change(function () {
        $('input[name="date_end"]').val($('input[name="market_year_end"]').val());
        change_hash($(this).closest('.chart-item'));
    });
    $('#discrete').change(function () {
        change_hash($(this).closest('.chart-item'));
    });
    $('#chart_type').change(function () {
        change_hash($(this).closest('.chart-item'));
    });
    $(document).on('change', '.legend-place .series_type', function(){
        set_series_type($(this).closest('.chart-item'), $(this));
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
});

function closeLegend(e) {
	var li = e.data.li;
	var bound = e.data.bound;
	if (e.pageX < bound.left || e.pageX > bound.right || e.pageY < bound.top || e.pageY > bound.bottom) {
		li.removeClass('hover');
		$(document).off('mousemove', closeLegend);
	}
}

$(document).on('change', '.prices select, .stat select', function() {
    var sel = $(this);
    var form = sel.closest('form');
    var select_name = sel.attr('name');
    form.find('[name=_select]').val( select_name );

    var url = '/oldStatistics/statisticsFilter';
    if (sel.closest('.fieldset').is('.prices')) {
        url = '/oldStatistics/pricesFilter';
    }
    if (sel.is('select[name=instrument_id]')) {
        $.getJSON('/oldStatistics/pricesDates', {instrument_id: sel.val()}, function(data) {
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
        $.getJSON(url, form.serialize(), function(data) {
            $.each(data, function(k, v) {
                var _sel = $('select[name=' + k + ']');
                if (_sel.length > 0) {
                    var val = _sel.val();
                    if (val != '' && k == select_name) {
                        if (_sel.find('option').length == 2) {
                            if (_sel.is('select[name=commodity_id]')) _sel.find('option:first').text('Выберите другой товар...')
                            if (_sel.is('select[name=country_id]')) _sel.find('option:first').text('Выберите другой регион...')
                            if (_sel.is('select[name=attribute_id]')) _sel.find('option:first').text('Выберите другой показатель...')
                        }
                        return;
                    }
                    _sel.html(v).val(val);
                    if (_sel.find('option').length == 2 && val != '') {
                        if (_sel.is('select[name=commodity_id]')) _sel.find('option:first').text('Выберите другой товар...')
                        if (_sel.is('select[name=country_id]')) _sel.find('option:first').text('Выберите другой регион...')
                        if (_sel.is('select[name=attribute_id]')) _sel.find('option:first').text('Выберите другой показатель...')
                    }
                }
            });
            if (data.min_year) {
                form.find('.dates').html( data.min_year + ' .. ' + data.max_year )
            }
        });
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
    form.find(':input').val('');
    form.find('select:first').change();
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
    location.hash = encode_hash(raw_data);
    on_hash_change(chart_item);
}

function parse_url () {
	var res = '';

	$('.page-title').show();

	var url_obj = window.location.pathname.split('-')[0];
	var url_obj = url_obj.split('/');

	var date = new Date();
	date = date_param(date);
	
	if (url_obj[1] == 'oldStatistics'){
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
            var chd = {
                series_type: series_type,
                type: 'statistics',
                commodity_id: p[0],
                country_id: p[1],
                attribute_id: p[2]
            }
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
        var max_date = period[1].split('.');
        max_date = max_date[2].toString() +'-'+ max_date[1].toString() +'-'+ max_date[0].toString();
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
            p[0] = 'commodity_id='+p[0];
            p[1] = 'country_id='+p[1];
            p[2] = 'attribute_id='+p[2];
        } else if (type == 'prices') {
            url = '/oldStatistics/pricesData';
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
        chart_a.push(series_type);
        if (type == 'statistics') {
            if(el.data.length > 0) {
                if (el.data[0].commodity_id && el.data[0].country_id && el.data[0].attribute_id) {
                    chart_a.push(type);
                    chart_a.push(el.data[0].commodity_id);
                    chart_a.push(el.data[0].country_id);
                    chart_a.push(el.data[0].attribute_id);
                }
            } else {
                if (window.charts_hash_data[i]) {
                    chart_a.push(window.charts_hash_data[i].type);
                    chart_a.push(window.charts_hash_data[i].commodity_id);
                    chart_a.push(window.charts_hash_data[i].country_id);
                    chart_a.push(window.charts_hash_data[i].attribute_id);
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
				setStatFields(window.charts_hash_data[i]);
			}
        });
    });
}

function change_hash (chart_item) {
//    return;
    window.candlesticks_alert = true;

    var chart_params = chart_item.data('chart_params');

    var chart = chart_params.chart;
    var chart_data = chart_params.data;
    var options = chart_params.options;
    var raw_data = chart_params.raw_data;

    var min_date = new Date(chart_item.find('input[name="market_year_begin"]').val());
    var max_date = new Date(chart_item.find('input[name="market_year_end"]').val());
    var discreteness = chart_item.find('#discrete').val();
    var chart_type = chart_item.find('#chart_type').val();

    options.seriesType = chart_type;

    if (raw_data.length == 0) {
        chart_item.data('chart_params', chart_params);
        return;
    }
    $.each(raw_data, function (i, el){

        if (el.min_date) {
            if (isValidDate(min_date)) {
                el.min_date = min_date;
            }
        }
        if (el.max_date) {
            if (isValidDate(max_date)) {
                el.max_date = max_date;
            }
        }
        el.discreteness = discreteness;
        location.hash = encode_hash(raw_data);
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
		chartArea: {'width': '80%', 'height': '80%'},
        colors: colors,
        hAxis: {
            viewWindowMode: 'pretty'
        },
        vAxis: {
            textPosition: 'out'
        },
        legend: {
            position: 'none'
        },
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
//        chart_item.find('#chart_type option[value='+s_t+']').attr('selected', 'true');
//        options.seriesType = s_t;
        parse_hash_data();
    } else {
		if ($('body').is('.auth')) {
    		on_hash_change(chart_item);
		}
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
    chart_data.addColumn('date', 'Дата');
    chart_params.data = chart_data;
    
    var min_date = parseDate('2100-01-01');
	var max_date = parseDate('1900-01-01');

    var min_value = Number.MAX_VALUE;
    var max_value = Number.MIN_VALUE;

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
	    chart_data.addRow([date]);

    }

    for (i = 0; i < raw_data.length; i++) {
	    var item = raw_data[i];
        if (item == undefined) continue;
	    chart_data.addColumn('number', item.name);

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
	    
	    for (j = 0; j < data.length; j++) {
	    	var di = data[j];
	    	
	    	var row_index = row_indexes[ parseDate(di.date) ];

	    	if (typeof row_index == 'undefined') {
		    	continue;
	    	}
	    	
	    	chart_data.setCell(row_index, 0, parseDate(di.date));

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
		}
    }
    
    var legend_place = chart_item.find('.legend-place').empty();
    
    for (var i = 0; i < raw_data.length; i++) {
        if (raw_data[i] == undefined) continue;
        var item_text = raw_data[i].name;
        var item_comment = raw_data[i].comment;;
        if (raw_data[i].data.length == 0) {
        	item_text += ' Нет данных за выбранный период с указанной дискретностью';
        }
//        var li = $('<li></li>');
//        li.append($('<span></span>').css('background-color', colors[i]));
//        var div = $('<div></div>').text(item_text);
//        div.append('<select><option value=""></option></select>')
    	$('<li></li>').append(
    		$('<span></span>').css('background-color', colors[i])
    	).append(
            $('<div></div>').text(item_text).append(
                $('<em></em>').text(item_comment)
            )
        ).append(
            $('<label>Тип графика</label>').append(
                    $('<select class="series_type"><option value="line">Линии</option><option value="candlesticks">Свечи</option><option value="bars">Гистограмма</option><option value="area">Области</option></select>').val(raw_data[i].series_type)
                )
        ).append(
            $('<a href="#" class="close">Удалить</a>').click(remove_chart)
        ).appendTo(legend_place);
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
    } else {
        chart_item.show();
        chart.draw(chart_data, options);
        google.visualization.events.addListener(chart, 'onmouseover', function (e) {
            Helpers.debounce(add_news(e, chart_item), 500);
        });
    }
    chart_item.data('chart_params', chart_params);
    location.hash = encode_hash(raw_data);
}

function remove_chart (e) {
    e.preventDefault();
    if (confirm('Удалить?')) {
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
        accord_count++;
        if (el.series_type == 'candlesticks') accord_count = accord_count+3;

    });

    var ci = e.column-1;

    var discreteness = raw_data[accord[ci]].discreteness;

    var date = chart_data.getValue(e.row, 0);

    var begin_date = new Date(Date.parse(date));
    var end_date = new Date(date);
    if (discreteness == 'year') {
        end_date.setFullYear(date.getFullYear()+1);
    } else if (discreteness == 'month') {
        end_date.setMonth(date.getMonth()+1);
    } else if (discreteness == 'day') {
        end_date.setDate(date.getDate()+1);
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
    });
}

var setPricesFields = function(instrument) {
	if (instrument) {
		var selects = $('.prices select').not('#instrument_id');
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
	}
}

var setStatFields = function (data) {
	if (data) {
		var selects = $('.stat select');
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
	}
}

$(document).on('click', '#add_stat_chart, #add_price_chart', function(e) {
    e.preventDefault();
    var $this = $(this);
    var form = $(this).closest('form');

    var chart_item = $this.closest('.chart-item');

    window.candlesticks_alert = true;

	$('.page-title').hide();

    var url = form.attr('action');
    if ($this.is('#add_price_chart')) {
        if (!$('#instrument_id').val()) {
            alert(t('Выберите инструмент'))
            return
        }
    	url = '/oldStatistics/pricesData';
        var chd = {
            type: 'prices',
            instrument_id: $('#instrument_id').val()
        }
        window.charts_hash_data.push(chd);
    } else {
        if (!$('#commodity_id').val() || !$('#country_id').val() || !$('#attribute_id').val()) {
            alert(t('Выберите товар, регион и показатель'));
            return;
        }
        var chd = {
            type: 'statistics',
            commodity_id: $('#commodity_id').val(),
            country_id: $('#country_id').val(),
            attribute_id: $('#attribute_id').val()
        }
        window.charts_hash_data.push(chd);
    }

    var params = form.serialize();
    get_raw_data(url, params, chart_item);
});
