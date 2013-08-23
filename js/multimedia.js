function fileQueueError(fileObj, error_code, message) {

    if (SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED==error_code) {
    }
    alert(t('Ошибка при добавлении файла:')+' fileQueueError ' + error_code + message);
}

function fileDialogComplete(num_files_queued) {
    try {
        if (this._params['insertMode'] != 'many' && num_files_queued > 1) {
                alert(t('В данном случае можно загружать только один файл.'));
            return false;
        }
        if (num_files_queued > 0) {
            this.startUpload();
        }
    } catch (ex) {
        this.debug(ex);
    }
}

function create_jquery_fileupload(params){
	var container = params.containerDiv;
	params.containerDiv.bind('dragleave',function(){
		$(this).removeClass('dragged');
	});
	params.containerDiv.find('input').fileupload({
		//sequentialUploads: true,   это параметр, благодаря которому можно сделать последовательную загрузку файлов
		dataType: 'json',
		url: '/media/uploadFile',
		dropZone: params.containerDiv,
		formData:[
			{name:"authorize_from_params",value: "1"},
			{name:"json_page",value: "1"},
			{name:"PHPSESSID",value: jQuery.cookies.get('PHPSESSID')}],
		add: function(e, data){
			if (params.insMode != 'many'){
				params.containerDiv.find('ul').find('li').each(function(){
					$(this).addClass('hidden').fadeOut(10);
				})
			}
			$.each(data.files, function(index,file){
				var item=$('<li></li>').data('filename',file.name).addClass('uploading');
				item.append('<span class=\'percents\'></span><div class=\'progress\'></span><div class=\'bar\'></div></div>');
				params.containerDiv.find('ul').append(item);
				data.submit();
			})
		},
		done: function (e, data) {
			console.log(data);
			if (data.result.status == 'error'){
				var filename = data.files[0].name;
				container.find('li.uploading').each(function(){
					if ($(this).data('filename') == filename){
						$(this).remove()
					}
				});
//				alert(data.result.message);
				$('body').trigger('triggerWrongFile',[data])
				return;
			}
			params.containerDiv
				.removeClass('dragged')
					//.find(params.progressClass).text('');
			$.each(data.files, function(index,file){
				add_file(data.result,{animate: false},params,file.name);
			});
		},
		dragover: function(){
			params.containerDiv.addClass('dragged');
		},
		fail: function(e, data){
			$.each(data.files, function(index,file){
				alert(t('Ошибка при добавлении файла')+' '+file.name+': ' + data.textStatus+' '+data.jqXHR.status+' - '+data.errorThrown);
				params.containerDiv.find('ul').find('li').each(function(){
					if ($(this).data('filename') == file.name) {
						$(this).fadeOut('fast', function(){
							$(this).siblings().removeClass('hidden').fadeIn(10);
							$(this).remove(10);
						});
					}
				})
			});
			params.containerDiv
				.removeClass('dragged')
				//.find(params.progressClass).text('');
		},
		progress: function(e,data){
			$.each(data.files, function(index,file){
				var progress = parseInt(data.loaded / data.total * 100, 10);
				params.containerDiv.find('ul').find('li').each(function(){
					if ($(this).data('filename') == file.name) {

						$(this).find('.percents').text(progress + '%');
						$(this).find(params.progressClass).find('.bar').css('width',progress+'%');
					}
				})
			})
		}
	});
}

function add_file(data,_opt,_params, fileName) {
    var input;
    var alink;
    var opt = jQuery.extend({},_opt);
    var realThis = this;
	var fileNameOrig = fileName;

    if (opt['animate'] == false) {
        jQuery.fx.off = true;
    }

    var item = jQuery("<li></li>").data('file',data);

    item.append(
        jQuery("<a></a>")
            .attr({
                'class': 'delete',
                'title': t('Удалить файл')
            })
            .click(function(){
                if (confirm(t('Удалить?'))) {
                    item.hide('slow',function(){
                        jQuery(this).remove();
                    })
                }
                return false;
            })
    );

    item.append((alink = $('<a class="icon"></a>'))
        .attr({
            href: data['file_url'],
            target: '_blank'
        })
        .append($('<img/>')
            .attr("src",function(){
                    var url = data['preview_url'];
                    // TODO Добавить вывод превью для видео
                    if (data['type'] != 1) {
                        var ext = data['ext'].split('.').slice(-1)[0].toLowerCase();
                        if (['','xls','doc','pdf','wmv','flv', ''].join(',').indexOf(ext) == -1) {
                            ext = 'other'
                        }
                        url = '/img/icons/ext/'+ext+'.png';
                    } else {
                        alink
                            .attr({
                                rel: 'images'+_params.fieldN,
                                href: data['file_url'] //раньше было middle
                                // title: data['comment'] || data['name']
                            })
                            .fancybox({
                                showNavArrows: true,
                                cyclic: true
                            })
                            .data('bigPhoto', {
                                href: data['file_url']
                            });
                    }
                    return url;
                }()
            )
            // .css({'min-height':50,'min-width':50})
            // не понятно зачем это было нужно
        )
    );

    item.append($('<input type="hidden" />')
        .attr({
            'name': _params.fieldN,
            'value': data['id']
        })
    )
    if (_params.insMode == 'many') {
        item.append(
            $('<input type="text">')
            .attr({
                "name": "mediaComments[]",
                "value": data['comment'],
		        "placeholder": t('Комментарий')
            }).bind()
        )
    }

    item.hide();
	if (_params['insMode']!='many' && fileNameOrig) {
		_params['containerDiv'].find('ul').empty().append(item);
	} else if (fileNameOrig) {
		_params['containerDiv'].find('ul').find('li').each(function(){
			if ($(this).data('filename') == fileNameOrig) {
				$(this).after(item).remove();
			}
		});
	} else {
		_params['containerDiv'].find('ul').append(item);
	}

    item.show('slow');
    jQuery.fx.off = false;
}
