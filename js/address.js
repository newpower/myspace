var address_path = '/address';

function getChildren(params, callback) {
	jQuery.ajax({
		type: "GET",
		url: address_path + '/children',
		data: params,
		dataType: 'jsonp',
		success: callback
	});
}

function getPath(params, callback) {
	jQuery.ajax({
		type: "GET",
		url: address_path + '/getPath',
		data: params,
		dataType: 'jsonp',
		success: callback
	});
}

function getIndex(params, callback) {
	jQuery.ajax({
		type: "GET",
		url: address_path + '/getIndex',
		data: params,
		dataType: 'jsonp',
		success: callback
	});
}

function getPathsWithoutStreet(params, callback) {
	jQuery.ajax({
		type: "GET",
		url: address_path + '/getPathsWithoutStreet',
		data: params,
		dataType: 'jsonp',
		success: callback
	});
}

function on_blur() {
	var el = jQuery(this);
	if (el.attr('_old_value') != el.val()) {
		el.change();
	}
}

jQuery('.address_place select').live('change', function() {
	var el = jQuery(this);
	var parentDiv = el.closest('.region');
	var name = el.attr('name');
	el.nextAll('select').remove();
	if (el.find('option:selected').attr('_c') > 0) {
		load_children(el.val(), parentDiv, name);
	}
	el.attr('_old_value', el.val());

	var basis = jQuery(el).closest('.region').siblings('.basis:first');
	var basis_id = basis.attr('id');
	if (basis.length > 0) {
		basis = basis.find('.basis-select');
		var region = jQuery(el).parent().find('select')
		if (region.length > 1) {
			region = region.map(function () {
				return jQuery(this).val();
			}).get().join(',');
			var params = {
				region: region
			};

			jQuery.ajax({
				type: "GET",
				url: address_path + '/basis',
				data: params,
				dataType: 'jsonp',
				success: function (data) {
					basis.html(data.options_str).val( basis.attr('_old_value') );
					if(basis.find('option').length > 1) {
						basis.closest('.basis').show();
					} else {
						basis.closest('.basis').hide();
					}
				}
			});
		} else {
			basis.html();
			basis.closest('.basis').hide();
		}
	}
});

function create_select(options, level, name) {
	// console.log('create_select', arguments)
	var level_arr = ['', t('Все регионы'), t('Все регионы'), t('Все районы'), t('Все районы'), t('Все населенные пункты')];
	options = '<option value="">'+level_arr[level]+'</option>' + options;
	return jQuery('<select></select>').attr('name', name).html(
		options
	).attr('_old_value', 0).blur(on_blur);
	// return select;
}

function load_children(parent, parentDiv, name) {
	// debugger
	getChildren({
		parent: parent,
		options_str: 1
	}, function(data) {
		var lev;
		if (jQuery.isArray(data['list'])){
			lev = data['list'][0].level;
		} else {
			lev = data['list'].level;
		}
		new_sel = create_select(data['options_str'], lev, name);
		parentDiv.find('.address_place').append(new_sel)
//		if (jQuery(new_sel).find('option:selected').length) {
			jQuery(new_sel).find('option:first').attr('selected', 'selected');
//		}
	});
}
