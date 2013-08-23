$().ready(function() {
	if($("#mainmenu li:last-child a").text() == "Выйти") {
		$("#mainmenu li:last-child a").click(function() {
			return confirm("Вы действительно хотите выйти?");
		});
	}




	if($('textarea.wysiwyg').size() > 0) {
		$('textarea.wysiwyg').tinymce({
			// Location of TinyMCE script
			script_url : '/js/tiny_mce/tiny_mce.js',
			
			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			language : "ru",

			// Theme options
			theme_advanced_buttons1 : "code,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,myimage",
			/*theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",*/
			theme_advanced_buttons2 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

            setup: function(ed) {
                // Add a custom button
                var button_id = 'myimage';

                ed.addButton(button_id, {
                    title : 'Вставить картинку',
                    onclick : function() { }
                });


                var inserted;

                ed.onInit.add(function() {
                    var a = $('a[id$="'+button_id+'"]');


//                    console.log('tmce init', arguments, a.parent())
                    
                    if (!inserted) {
                        inserted = true;

                        ed.focus();

                        var c = $('<fieldset class="attachements singleMode" id="filecontainer666">' +
                            '<ul class=fileContainer></ul>' +
                            '<div class="progress"></div>' +
                            '<span id="spanButtonPlaceHolder"></span>' +
                            '</fieldset>').appendTo(a.parent());

                        /*
                        var swf_up = create_swf_upload({
                            progress_div_id: c.find('.progress'),
                            container: c.find('ul'),
                            fieldName: 'News[media_id]'
                                             ,
                            insertMode: 'single',

                       //    button_image_url: '/img/icons/img.gif',

                            button_text: '<span class="addFilesButton">добавить изображение</span>',

                            

                            add_file: function(data) {
                                ed.selection.setContent('<img src="'+data.file_url+'" />');
                            }
                          });
                          */

                    }

                });
            }
		});


	}
	
	$("#route").change(function() {
		if($(this).val() == 0){
			$("form span.url_hidden").css("display","inline");
		} else {
			$("form span.url_hidden").css("display","none");
			$("form span.url_hidden input[type=text]").val("");
		}
		return false;
	});
});

$(function () {
	$(document).on('click', '.delete_message_button', function (e) {
		e.preventDefault();
		var $this = $(this);
		if (!confirm('Удалить?')) {
			return false;
		}
		$.get($this.attr('href'), function (data) {
			if (data.status = 'success') {
				$this.closest('td').siblings('.is_deleted').html('1');
				$this.remove();
			}
		}, 'json')
	});
	
	$(document).on('click', '.really_delete_message_button', function (e) {
		e.preventDefault();
		var $this = $(this);
		if (!confirm('Удалить навсегда?')) {
			return false;
		}
		$.get($this.attr('href'), function (data) {
			if (data.status = 'success') {
				$this.closest('tr').remove();
			}
		}, 'json')
	});
});

function removeItem(baseurl,id,url) {
	if(!confirm('Вы действительно хотите удалить запись?')) return false;
	$.ajax({
		type:'POST',
		url:baseurl+url+'delete?ajax=1&id='+id,
		success:function() {
			document.location.href = baseurl+url;
		}
	});
	return false; 
}