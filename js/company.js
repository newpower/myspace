
jQuery(document).ready(function($) {
	$('#btnCreateMemberRequest').click(function(e){
		e.preventDefault();
		var url = $(this).data('url');
//		var url = '<?php echo $this->createUrl('company/addMemberRequest'); ?>' + '/id/' + $('#company_to_join').val();
		if ($('#company_to_join').length > 0 && $('#company_to_join').val() != '') {
			url += '/id/' + $('#company_to_join').val();
		}
		$('#btnCreateMemberRequest').attr("disabled", "disabled");
		$.get(url,
			function(jsonResponse, status){
				if (status == 'success') {
					var json = jQuery.parseJSON(jsonResponse);
					if (json.status == 'success') {
//						$('#btnCreateMemberRequest').hide();
//						$('#btnDeleteMemberRequest').show();
						$('#btnCreateMemberRequest').removeAttr('disabled');
						$('#btnDeleteMemberRequest').removeAttr('disabled');
//                                alert('Заявка на вступление в компанию подана!');
						window.location.reload();
					} else if (json.status == 'error'){
						if (json.message) alert('Error: ' + json.message);
						if (json.errors) alert("Произошла ошибка");
						$('#btnCreateMemberRequest').removeAttr('disabled');
						$('#btnDeleteMemberRequest').removeAttr('disabled');
					}
				} else {
					alert('Произошла ошибка');
					$('#btnCreateMemberRequest').removeAttr('disabled');
					$('#btnDeleteMemberRequest').removeAttr('disabled');
				}
		});
	});

	$('#btnDeleteMemberRequest').click(function(e){
		e.preventDefault();
		var url = $(this).data('url');
		$('#btnDeleteMemberRequest').attr("disabled", "disabled");
		$.get(url,
			function(jsonResponse, status){
				if (status == 'success') {
					var json = jQuery.parseJSON(jsonResponse);
					if (json.status == 'success') {
//						$('#btnCreateMemberRequest').show();
//						$('#btnDeleteMemberRequest').hide();
						$('#btnCreateMemberRequest').removeAttr('disabled');
						$('#btnDeleteMemberRequest').removeAttr('disabled');
//                                alert('Заявка на членство в данной компании отозвана!');
						window.location.reload();
					} else if (json.status == 'error'){
						if (json.message) alert('Error: ' + json.message);
						if (json.errors) alert(t('Произошла ошибка'));
						$('#btnCreateMemberRequest').removeAttr('disabled');
						$('#btnDeleteMemberRequest').removeAttr('disabled');
					}
				} else {
					alert(t('Произошла ошибка'));
					$('#btnCreateMemberRequest').removeAttr('disabled');
					$('#btnDeleteMemberRequest').removeAttr('disabled');
				}
			});
	});

	$('#out-of-company').click(function (e) {
		e.preventDefault();
		var btn = $(this)
		var url = $(this).attr('href');
		var company_id = btn.data('companyId');
		if (!confirm(btn.attr('confirm'))) {
			return;
		}
		
		$.get(url,
			function (resp) {
				resp = jQuery.parseJSON(resp);
				if (resp.status == 'success') {
//					alert('Вы вышли из компании');
					btn.remove();
					window.location.href = '/company/create';
				} else {
					if (resp.message) alert(resp.message);
				}
			}
		);
	});


	$('.acceptMembership').click(function(e){
		e.preventDefault();
		var a = $(this);
		var block = a.closest('.company-members');
		var user_name = block.find('a.user-link').text();
		var user_id = $(this).attr('user_id');
		$('[user_id=' + user_id + ']').attr("disabled", "disabled");
		var url = '/company/acceptUserMembership';
		if (!confirm($(this).attr('confirm'))) {
			return;
		}
			$.get(url + "?user_id=" + user_id, function(jsonResponse, status){
				if (status == 'success') {
					var json = jQuery.parseJSON(jsonResponse);
					if (json.status == 'success') {
						if (block.find('.usr').length == 1) {
							block.hide(200);
						} else {
							a.closest('.usr').remove();
						}
//						alert('Пользователь принят в компанию');
						$.gritter.add({
							title: t('Уведомление'),
							text: t('Пользователь ') + user_name + t(' принят в компанию')
						});
					} else if (json.status == 'error'){
						if (json.message) alert('Error: ' + json.message);
						if (json.errors) alert(t('Произошла ошибка'));
						$('[user_id=' + user_id + ']').removeAttr('disabled');
					}
				} else {
					alert(t('Произошла ошибка'));
					$('[user_id=' + user_id + ']').removeAttr('disabled');
				}
			});
	});

	$('.declineMembership').click(function(e){
		e.preventDefault();
		var a = $(this);
		var block = a.closest('.company-members');
		var user_name = block.find('a.user-link').text();
		var user_id = $(this).attr('user_id');
		$('[user_id=' + user_id + ']').attr("disabled", "disabled");
		var url = '/company/declineUserMembership';
		if (!confirm($(this).attr('confirm'))) {
			return;
		}
			$.get(url + "?user_id=" + user_id, function(jsonResponse, status){
				if (status == 'success') {
					var json = jQuery.parseJSON(jsonResponse);
					if (json.status == 'success') {
						$('[user_id=' + user_id + ']').closest('.usr').remove();
//						alert('Заявка на вступление отклонена');
						$.gritter.add({
							title: 'Уведомление',
							text: 'Заявка на вступление отклонена'
						});
					} else if (json.status == 'error'){
						if (json.message) alert('Error: ' + json.message);
						if (json.errors) alert(t('Произошла ошибка'));
						$('[user_id=' + user_id + ']').removeAttr('disabled');
					}
				} else {
					alert(t('Произошла ошибка'));
					$('[user_id=' + user_id + ']').removeAttr('disabled');
				}
			});
	});

	$('.deleteMember').click(function(e){
		e.preventDefault();
		var a = $(this);
		var block = a.closest('.company-members');
		var user_id = $(this).attr('user_id');
		var url = '/company/deleteMember';
		if (!confirm($(this).attr('confirm'))) {
			return;
		}
			$.get(url + "?user_id=" + user_id, function(jsonResponse, status){
				if (status == 'success') {
					var json = jQuery.parseJSON(jsonResponse);
					if (json.status == 'success') {
						if (block.find('.usr').length == 1) {
							block.hide(200);
						} else {
							a.closest('.usr').remove();
						}
//						alert('Пользователь удален из компании');
					} else if (json.status == 'error'){
						if (json.message) alert(json.message);
						if (json.errors) alert(t('Произошла ошибка'));
					}
				} else {
					alert(t('Произошла ошибка'));
					$('[user_id=' + user_id + ']').removeAttr('disabled');
				}
			});
	});

    $('.appointAdministrator').click(function(e){
        e.preventDefault();
        var a = $(this);
        var block = a.closest('.company-members');
        var user_id = $(this).attr('user_id');
        var url = '/company/appointAdministrator';
        var company_view_url = $(this).attr('company_view_url');
        if (!confirm($(this).attr('confirm'))) {
            return;
        }
        $.get(url + "?user_id=" + user_id, function(jsonResponse, status){
            if (status == 'success') {
                var json = jQuery.parseJSON(jsonResponse);
                if (json.status == 'success') {
                    alert(t('Вы больше не являетесь администратором компании'));
                    $(location).attr('href', company_view_url);
                } else if (json.status == 'error'){
                    if (json.message) alert(json.message);
                }
            } else {
                alert(t('Произошла ошибка'));
            }
        });
    });

	$('#create-company').on('submit', function (e) {
        if ($('#company_to_join').val() && $('#company_to_join').val() != '' ) {
			e.preventDefault();
		}
        if (!$('#Company_inn').data('allowSubmit')) {
            e.preventDefault();
        }
	});

    $('#divOccupations').on('click', '.selectItemPlace.ajax', function () {
        var item = $(this).closest('.divOccupation')
        $(this).hide();
        item.find('.selectItem').show();
    });

    if ($('#Company_parent_id').length > 0) $('#Company_parent_id').combobox();
});


var cnt = 0;
function addOccupation() {
    var res = $.tmpl("occupation_template", {id : cnt++});
    res.appendTo("#divOccupations");
    return res;
}
function _addOccupation(division_id, item_id) {
    var res = addOccupation();
    res.find('.selectDivision').val(division_id).combobox();
    res.find('.selectItem').val(item_id);
    item_txt = res.find('.selectItem option[value="'+item_id+'"]').text()
    res.find('.selectItemPlace').text(item_txt)

    if (window.serviceIds) {
        if (window.serviceIds.indexOf(parseInt(division_id)) >= 0) {
            res.find('.selectItemPlace').removeClass('ajax');
        }
    }
    return res;
}

jQuery(function($) {
    $(document).ready(function() {
        if (window.occupationList) {
            var occupationList = window.occupationList;
        } else {
            return;
        }
        $("#occupation_template").template("occupation_template");
        $("#linkAddOccupation").click(function(e){
            e.preventDefault();
            var occupation = addOccupation();
            occupation.find('.selectDivision').combobox();
        });
        $(".linkDeleteOccupation").live('click', function(e) {
            e.preventDefault();
            $(this).closest('.divOccupation').remove();
        });
        for(var i = 0; i < occupationList.length; i++) {
            _addOccupation(occupationList[i].division_id, occupationList[i].item_id);
        }

        $('#divOccupations').on('change', '.selectDivision', function () {
//            console.log($(this).val(), window.serviceIds);
            var selDiv = $(this);
            var selItem = $(this).closest('.row').find('.selectItem');
            var pl = $(this).closest('.row').find('.selectItemPlace');
            if (window.serviceIds) {
//                console.log(window.serviceIds.indexOf(parseInt($(this).val())));
                if (window.serviceIds.indexOf(parseInt($(this).val())) >= 0) {
                    pl.text(t('оказывает услуги')).removeClass('ajax');
                    selItem.find(':selected').removeAttr('selected');
                    selItem.find('option').each(function (i, el) {
                        if ($(el).text() == t('оказывает услуги')) $(el).attr('selected', 'selected');
                    });
                    if (!pl.is(':visible')) {
                        pl.show();
                        selItem.hide()
                    }
                } else {
                    if (!pl.is('.ajax')) {
                        pl.text('продает').addClass('ajax');
                        selItem.find(':selected').removeAttr('selected');
                    }
                }
            }
        });
    });
});


