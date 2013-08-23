function fileQueueError(fileObj, error_code, message) {

    if (SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED==error_code) {
    }
    alert('Ошибка при добавлении файла: fileQueueError ' + error_code + message);
}

function fileDialogComplete(num_files_queued) {
    try {
        if (this._params['insertMode'] != 'many' && num_files_queued > 1) {
            alert('В данном случае можно загружать только один файл.');
            return false;
        }

        if (num_files_queued > 0) {
            this.startUpload();
        }
    } catch (ex) {
        this.debug(ex);
    }
}

function uploadProgress(fileObj, bytesLoaded) {
    try {
        var percent = Math.ceil((bytesLoaded / fileObj.size) * 100)
        var message = fileObj.name + " - загрузка (" + percent + "%)";
        if (percent == 100) {
            message = fileObj.name + " - идет обработка";
        }
        jQuery(this._params["progress_div_id"]).html(message);
    } catch (ex) { 
        alert(ex);
        this.debug(ex); 
    }
}

function uploadSuccess(fileObj, server_data) {
    var file_id = null;
    try    {
        data = json = window["eval"]("(" + server_data + ")");
        file_id = data['id'];
    } catch (ex) {}
    if (!(file_id > 0))    {
        alert("Не удалось добавить файл\r\nТект ответа сервера: " + server_data);
    }
    // debugger;
    this.add_file(data);
}

function uploadComplete(fileObj) {
    try {
        if (this.getStats().files_queued > 0) {
            this.startUpload();
        } else {
            jQuery(this._params["progress_div_id"]).html('');
        }
    } catch (ex) { this.debug(ex); }
}

function uploadError(fileObj, error_code, message) {
    alert('Ошибка при добавлении файла: uploadError' + error_code + message);
}

function create_swf_upload(params) {
    var _post_params = {
        "authorize_from_params": "1",
        "json_page": "1",
        "PHPSESSID": jQuery.cookies.get('PHPSESSID')
    };
    
    var swfu = new SWFUpload({
        upload_url: '/admin/media/uploadFile',
        flash_url: '/img/swfupload/swfupload.swf',
        
        file_queue_error_handler: fileQueueError,
        file_dialog_complete_handler: fileDialogComplete,
        upload_progress_handler: uploadProgress,
        upload_error_handler: uploadError,
        upload_success_handler: uploadSuccess,
        upload_complete_handler: uploadComplete,
        post_params: _post_params,
        button_image_url:  params.button_image_url || "/img/icons/add-swf.png",
        button_width: "150",
        button_height: "29",
        button_placeholder_id: "spanButtonPlaceHolder",
        button_text: params.button_text ||  '<span class="addFilesButton">загрузить файл'+((params['insertMode']=='many')?'ы':'')+'</span>',
        button_text_style: ".addFilesButton { color: #1A559F; font-size: 13px; font-family: Arial}",
        button_text_left_padding: 20,
        button_text_top_padding: 0,
        button_cursor : SWFUpload.CURSOR.HAND,
        button_window_mode : 'transparent'
    });
    swfu._params = params;
    swfu.add_file = params.add_file || add_file;
    return swfu;
};


function add_file(data,_opt) {
    var input;
    var alink;
    var opt = jQuery.extend({},_opt);
    var realThis = this;

    if (opt['animate'] === false) {
        jQuery.fx.off = true;
    }

    var item = jQuery("<li></li>").data('file',data);
    
    item.append(
        jQuery("<a></a>")
            .attr({
                'class': 'delete',
                'title': 'Удалить файл'
            })
            .click(function(){
                if (confirm('Удалить?')) {
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
//                    console.log(data);
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
                                rel: 'images'+realThis._params['fieldName'],
                                href: data['file_url'] //раньше было middle
                                // title: data['comment'] || data['name']
                            })
                            .colorbox({})
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
            'name': this._params['fieldName'],
            'value': data['id']
        })
    )
    if (this._params['insertMode'] == 'many') {
        item.append(
            $('<input type="text">')
            .attr({
                "name": "mediaComments[]",
                "value": data['comment']
            })
        )
    }


    item.hide();
    //console.log(this._params['insertMode']);
    if (this._params['insertMode']!='many') {
        this._params['container'].empty()
    }
    this._params['container'].append(item);
    item.show('slow');
    jQuery.fx.off = false;
}
