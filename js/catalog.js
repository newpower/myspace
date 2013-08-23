$(function() {
$('.left .catalog.js, .catalog.js.create').each(function() {
//        $('#catalog-block-template').template('catalog_block_template');
    $('#catalog-select-template').template('catalog_select_template');

    var menu = $(this);
    var region_select_hidden = true;
    var first_select_change = true;

    var selected = function(item_or_id) {
        //set selected
        if (typeof item_or_id != 'undefined') {
            var i = item(item_or_id);
            block(i).find('.item').removeClass('selected');
            i.addClass('selected');


            if (menu.is('.edit')) {
                $('#division_id').val(id(i));
                $('#content h1 .div').text(i.text())
            }
        }

        //get selected
        var s = $(block().not('.hidden').find('.item.selected').get().reverse());
        if (!s.length) 1; // TODO get from location.hash

        return s.length ? s : undefined;
    };

    var opt_selected = function(item_or_id) {
        //set selected
        if (typeof item_or_id != 'undefined') {
            var i = item(item_or_id);
            select(i).find('option').removeAttr('selected');
            i.attr('selected', 'selected');


            if (menu.is('.edit')) {
                $('#division_id').val(id(i));
                $('#content h1 .div').text(i.text())
            }
        }

        //get selected
        var s = $(block().not('.hidden').find('.item.selected').get().reverse());
        if (!s.length) 1; // TODO get from location.hash

        return s.length ? s : undefined;
    };

    var open = function(p) {
        var b = block(p);
        var was_closed = b.is('.closed') && !b.is('.hidden');
        var opened = b.removeClass('hidden closed').addClass('opened');

        if (!was_closed) {
            opened.find('.cc').hide().show(300, function() { });
        }


        var parents = $('');
        if (!opened.is('.block-types')) parents = parents.add(block('-types'));

        var d = opened.data('rdata');


        if (d && d.divisions) {
            $.each(d.divisions, function(i,div) {
                $.each(div, function(i,it) {
                    if (it.selected) {
                        parents = parents.add(block(item(it.id)))
                    }
                })
            });
        }

        close(parents);

        hide(block().not(opened).not(parents));
    };

    var close = function(p) {
        return block(p).removeClass('hidden opened').addClass('closed');
    };

    var hide = function(p) {
        return block(p).removeClass('opened closed').addClass('hidden');
    };

    var item = function(item_or_id) {
        var i, items = menu.find('.item-sel option');

        if (typeof item_or_id != 'undefined') {
            if (item_or_id.className) item_or_id = $(item_or_id);
            if (item_or_id.is && item_or_id.is('option')) return item_or_id;
            var i = item_or_id.addClass ? item_or_id : items.filter('.item' + item_or_id);
            i.filter(function() {
                if(!$(this).is('.empty')) {
                    return this
                }
            });
//              if (!i.closest('option').is('.empty')) {
//                i = i.closest('option');
        } else {
            i = items
        }

        return i;
    };

    var block = function(item_or_id) {
        var b, blocks = menu.find('.block');
        if (typeof item_or_id != 'undefined') {
            if (item_or_id.className) item_or_id = $(item_or_id);
            if (item_or_id.is && item_or_id.is('.block')) return item_or_id;
            b = item_or_id.addClass ? item_or_id : blocks.filter('.block' + item_or_id);
            b = b.closest('.block');
        } else {
            b = blocks
        }

        return b;
    };


    var select = function(item_or_id) {
        var b, blocks = menu.find('.select-items .item-sel');
        if (typeof item_or_id != 'undefined') {
            if (item_or_id.className) item_or_id = $(item_or_id);
            if (item_or_id.is && item_or_id.is('.item-sel')) return item_or_id;
            b = item_or_id.addClass ? item_or_id : blocks.filter('.sel' + item_or_id);
            b = b.closest('.item-sel');
        } else {
            b = blocks
        }

        return b;
    };


    var render_block = function(data) {
        var b = $.tmpl('catalog_block_template', data);
        b.appendTo(menu.find('.items'));
        b.data('rdata', data);
        return b;
    };


    var render_sel = function (data) {
        var s = $.tmpl('catalog_select_template', data);
        var bool = false;
        //console.log(data);
        $.each(data['children'],function(){
            if (this.isWritable == 0 && data.id == this.parent_id) {
                bool = true;
            }
        });
        var text = bool ? t('Укажите раздел') : t('Укажите товар');

        if (menu.is('.job')){
            text = t('Уточните специализацию');
        }
        s.find('.empty').text(text);
        s.appendTo(menu.find('.select-items'));
        s.data('rdata', data);
        return s;
    };


    var rem_descend = function (item) {
        var rem = 0;
        menu.find('.item-sel').each(function () {
            if (rem == 1) {
                $(this).remove();
            }
            if ($(this)[0] == item[0]) {
                rem = 1;
            }
        });
    }

    var setBidtype = function (type) {
        offer.type = type;
        var cl='type-'+type;
        menu.find('.bidtype').hide();
        menu.find('.catalog_tabs').hide();
        menu.find('.select-items').show();
        $('.search_divisions').css('top', '0px').show();
        $('.intro').hide();
        if (menu.is('.job')) {
            if (menu.is('.search')) {
                if (type == 1) {
                    $('#layout-content h1').text(t('Поиск резюме'));
                    if (menu.is('.vacancy')) {
                        menu.removeClass('vacancy').addClass(t('resume'));
                    }
                } else if (type == 2) {
                    $('#layout-content h1').text(t('Поиск вакансий'));
                }
            } else if (menu.is('.create')) {
                if (type == 1) {
                    $('#layout-content h1').append(t(' резюме'));
                    if (menu.is('.vacancy')) {
                        menu.removeClass('vacancy').addClass('resume');
                    }
                } else if (type == 2) {
                    $('#layout-content h1').append(t(' вакансию'));
                }
            }
        } else {

            if (type == 1) {
                $('#layout-content h1').append(t(' на продажу'));
                if (menu.is('.demand')) {
                    menu.removeClass('demand').addClass('offer');
                }
            } else if (type == 2) {
                $('#layout-content h1').append(t(' на покупку'));
            }
        }
    }


    var load = function(params) {
        // TODO show loader

        if (menu.ajax) {
            menu.ajax.abort()
            delete menu.ajax;
        }

        params.dataType = 'json';

        if (params.success) {
            params.success = _.wrap(params.success, function(f, data) {
                f.apply(null, [data]);
                on_load(data);
            })
        } else {
            params.success = on_load;
        }

        menu.ajax = $.ajax(params.url, params);

        return menu.ajax;
    };


    var on_load = function(data) {
        delete menu.ajax;
        $(document).trigger('update_catalog_data', [data]);

        menu.find('.non-writable').toggle(menu.is('.create') && !data.divIsWritable);


    };


    var type_id_reg = /(block|item|type)(\d+)/;
    var id = function(el) {
        var m = ((el[0] || el).className || '').match(type_id_reg) || [];
        return m[2];
    };

    var create_offer_link = function (hash, param) {
        if ($('#create_this_offer a').length > 0) {
            var link = $('#create_this_offer a');
            var h = link.attr('href').split('#')[0] + '#' + hash;
            var type_names = ['', t('на продажу'), t('на покупку')];

            var text = type_names[param.type] + ' '+t('в разделе')+'  "' + item(param.division_id).text() + '"';

            if (menu.is('.job')) {
                text = ' '+t('в разделе')+'  "' + item(param.division_id).text() + '"';
            }
            link.attr('href', h).next('span').text(text);
            //          $('#create_this_offer').show();
        }
    }

    var input = Helpers.debounce(function($this, e, data) {
        var q = $.param($this.closest('form').serializeArray());
        if (q == last_query) return;
        last_query = q;
        $this.closest('form').submit();
    }, 600);

    var attachFormEvents = function() {
        menu.find('form').submit(on_form_submit);

        if (menu.is('.search')) {
//                    menu.on('click change keyup', 'form :input', input);
            menu.on('click change keyup', 'form :input', function (e, data) {
                if (data && data.region_load) return false;
                input($(this), e, data);
            });
        }

        menu.find('form .date_range input').datepicker();
        menu.find('form .date input').datepicker();
        menu.find('form select[multiple]').multiselect({
            //minWidth: 10,
            header: false,
            noneSelectedText: t('Выберите...'),
            selectedText: function(a,b,arr) {
                s = [];
                $.each(arr, function(i,v) {
                    s.push($(v).next().text());
                });

                return s.join(', ');
            }
        });
        if (region_select_hidden && menu.is('.create')) {
            menu.find('.region-show').show().click(showRegions);
            menu.find('.address_place').hide();
        }
    }

    attachFormEvents();

    load_form = function (url, division_id) {
        load({
            url: url,
            success: function(data) {

                rem_descend($('.select-items select:first'));

                var div = {};
                div.divisions = data.divisions;
                div.same = [];
                div.children = data.children;
                build_tree(div);
                if (data.children.length && division_id != '44805') {
                    render_sel(data);
                }

                console.log('load search forn from server', data, menu, menu.find('.form'))

                menu.find('.form').html(data.form);

                attachFormEvents();

//                      menu.find('.address_place select:last').change();
            }
        });
    }

    var d_search = function () {
        var $this = $(this);
        var prompt = $this.closest('.prompt_place');
        var txt = $(this).text();
        var search_inp = $this.closest('.search-divisions').find('.text');
        search_inp.val(txt);
        var divisions = $(this).attr('data-path').split(', ');
        var form = menu.find('form');
        if (form[0]) {
            rem_descend(menu.find('.select-items .item-sel:first'));
            form.find('input[name="model[division_id]"]').val(divisions[divisions.length - 1]);
            var param = form.serializeObject();

            var regions = new Array();
            $.each(form.find('.region select option:selected'), function(){
                if (parseInt($(this).val())) {
                    regions.push($(this).val());
                }
            });
            param['model[general][region][]'] = regions;
        } else {
            param = {};
            param.type = 1;
//            if($this.closest('.bidtype')[0]) param.type = $this.closest('.bidtype')[0].className.split('-')[1];
            if (menu.find('.bidtype:visible').length > 0) {
                param.type = menu.find('.bidtype:visible')[0].className.split('-')[1];
            }
            setBidtype(param.type);
        }
        param['json'] = 1;

        var division_id = divisions[divisions.length - 1];
        param.division_id = division_id;
        param['model[division_id]'] = division_id;
        param = $.param(param);
        url = menu.find('.select-items .item-sel:first option:last').attr('link').split('?')[0];
        if (menu.is('.edit')) {
            url = '/offer/getdivisions';
        }
        url = url + '?' + param;
        window.location.hash = param;
        menu.ajax = load_form(url, division_id);
        prompt.hide();
    }

    function prompt_hide (e) {
        var targ = $(e.target);
        var prompt = e.data.obj;
        var inp = prompt.closest('.search_divisions').find('.text');
        eng();
        function eng () {
            if (targ[0] == prompt[0]) {
                return
            } else if (targ[0] == inp[0]) {
                return
            } else if (targ[0] == $('body')[0]) {
                e.data.obj.hide();
                $(document).off('click', prompt_hide);
                return
            } else {
                targ = targ.parent();
                eng();
            }
        }
    }

    var prompt_show = function (p) {
        p.fadeIn(100);
        $(document).on('click', {obj: p}, prompt_hide);
    }

    var prompt_list = function (list) {
        var res = '';
        $.each(list, function() {
            var path = this.path.join(', ');
            res += '<div data-path="' + path + '">' + this.name + '</div>';
        });
        return res;
    }

    var promt_get_div = function (inp) {
        var val = inp.val();
        var url = inp.data('url');
        var prompt = inp.closest('.search_divisions').find('.prompt_place');
        var param = new Object();
        param.text = val;
        if(val in window.search_division_cashe) {
            var plist = prompt_list(window.search_division_cashe[val]);
            prompt.html(plist);
            prompt_show(prompt);
        } else {
            if (val.length > 1 ) {
                inp.addClass('loading');
                $.ajax({
                    url: url,
                    data: param,
                    global: false,
                    success: function (data) {
                        data = JSON.parse(data);
                        if (data.list.length > 0) {
                            var plist = prompt_list(data.list);
                            prompt.html(plist);
                            prompt_show(prompt);
                            window.search_division_cashe[param.text] = data.list;
                        } else {
                            prompt.empty().hide();
                        }
                        inp.removeClass('loading');
                    }
                });
            } else {
                prompt.empty().hide();
            }
        }
    }

    var d_prompt =
        Helpers.debounce(
            function(e) {
                var key = e.keyCode;
                if ($.inArray(key, window.prompt_excl_keys) > -1) {

                } else {
                    promt_get_div($(this));
                }
            }
            , 300);

    var key_prompt = function (e) {
        var $this = $(this);
        var key = e.keyCode;
        var prompt = $this.closest('.search_divisions').find('.prompt_place');
        if(prompt.find('div').length > 0) {
            if (key == 40 || key == 38 || key == 13) {
                if (key == 40) {
                    if (prompt.is(':hidden')) {
                        prompt_show(prompt);
                        return;
                    }
                    var next_item = prompt.find('div.selected').next();
                    if (next_item.length == 0 ) next_item = prompt.find('div:first');
                    prompt.find('div.selected').removeClass('selected');
                    next_item.addClass('selected');
                    $this.val(next_item.text());
                } else if (key == 38) {
                    if (prompt.is(':hidden')) {
                        prompt_show(prompt);
                        return;
                    }
                    var prev_item = prompt.find('div.selected').prev();
                    if (prev_item.length == 0 ) prev_item = prompt.find('div:last');
                    prompt.find('div.selected').removeClass('selected');
                    prev_item.addClass('selected');
                    $this.val(prev_item.text());
                } else if (key == 13) {
                    prompt.find('div.selected').click();
                }
            }
        } else {
            if (key == 40 || key == 38) {
                promt_get_div($this);
            }
        }
    }

    window.search_division_cashe = {};
    window.prompt_excl_keys = [40, 38, 39, 37, 13];

    menu.on('keydown', '.search_divisions .text', key_prompt);
    menu.on('keyup', '.search_divisions .text', d_prompt);
    menu.on('focus', '.search_divisions .text', function () {
        var $this = $(this);
        var prompt = $this.closest('.search_divisions').find('.prompt_place');
        if(prompt.find('div').length > 0) {
            if (prompt.is(':hidden')) {
                prompt_show(prompt);
            }
        }
    });
    menu.find('.search_divisions .prompt_place > div').live('click', d_search).live('mouseenter', function () {
        menu.find('.search_divisions .prompt_place > div').removeClass('selected');
        $(this).addClass('selected');
    });

    var before_load = function (item_id, href) {
        search_regions = '';

        if (window.location.hash) {
            search_regions = new Array();
            $.each(menu.find('.region select option:selected'), function(i){
                if (parseInt($(this).val())) {
                    search_regions.push($(this).val());
                }
            });
        }
        else {
            if (typeof user_regions != "undefined") search_regions = ''; //user_regions;

        }

        first_select_change = false;

        var p = {
            json:1,
            type: menu.data('type') || offer.type,
            'model[division_id]': item_id ,
            'division_id': item_id,
            'model[general][region][]': search_regions
        };

        var url = href + '&' + $.param(p);
        location.hash = $.param(p);
        create_offer_link($.param(p), p);

        if (menu.is('.edit')) {
            url = '/offer/getdivisions?' + $.param(p);
        }

//        if (menu.is('.search')) {
//            menu.on('click change keyup', 'form :input', input);
//        }
        
        load_form(url, item_id);
    }

    menu.on('click', '.bidtype ul a', function(e) {
        e && e.preventDefault();

        var a = $(this);
        var thisId = id(a);
        var bt = a.closest('.bidtype');
        if (bt.is('.type-1')) {
            setBidtype (1);
        } else if (bt.is('.type-2')) {
            setBidtype (2);
        }
//        menu.find('.select-items')
//            .find('.item-sel option.item' + thisId)
//            .attr('selected', 'selected');
//        menu.find('.select-items .item-sel').change();

        var action = a.attr('href');
        if (menu.is('.search')){
            action = '/offer/search?';
        } else if(menu.is('.create')) {
            action = '/offer/create?';
        }

        before_load(thisId, action);
    });

    menu.on('change', '.item-sel', function(e) {
        e && e.preventDefault();

        var s = $(this);
        var opt = s.find('option:selected');
        if (opt.is('.empty')) {
            rem_descend(s);
            if (opt.is('.item00')) {
                return
            }
        }
        if (opt.text() != $('#search_divisions').val()) $('#search_divisions').val('')

        var item_id = $(this).val();

        if (s.is('.disabled')) return;

        if (s.is('.type-1')) {
            setBidtype (1);
        } else if (s.is('.type-2')) {
            setBidtype (2);
        }

        before_load(item_id, opt.attr('link'));

    });


    var build_tree = function(offer) {

        item('.item-type'+offer.type).each(function() {
            menu.data('type', id(this))
            selected(this);
            close(block(this));
        });

        var last = [];

        $.each(offer.divisions, function(i,div) {
            $.each(div, function(ii, it) {
                if (it.selected) {
                    var ch = offer.divisions[i + 1];

                    last.push([{
                        selected: 1,
                        id: it.id
                    }]);

                    if (ch) {
                        render_sel({
                            id: it.id,
                            children:ch,
                            divisions:$.extend(true, {}, { l:last }).l,
                            isWritable: it.isWritable
                        });
                    }

                    item(it.id).each(function() {
                        opt_selected(this);
//                            close(block(this));
                    });
                }
            });
        });
    };



    var s = selected();
    if (s) {
        // TODO set real selected
    } else if (offer.divisions) {

        build_tree(offer);

        $('.catalog').find('form select[multiple]').multiselect({
            //minWidth: 10,
            header: false,
            noneSelectedText: t('Выберите...'),
            selectedText: function(a,b,arr) {
                s = [];
                $.each(arr, function(i,v) {
                    s.push($(v).next().text());
                });

                return s.join(', ');
            }
        });



    } else {
        var hash = window.location.hash;
        var url = window.location.toString();

        if (!hash){
            var params = [], temp;
            
            var urlParams = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

            for(var i = 0; i < urlParams.length; i++)
            {
                temp = urlParams[i].split('=');
                params.push(temp[0]);
                params[temp[0]] = temp[1];
            }

            if (window.location.href.indexOf('searchView') > 0) {
                var urlParams = window.location.href.slice(window.location.href.indexOf('searchView') + 11).split('/');
                if (urlParams) {
                    if (urlParams[0]) params['division_id'] = urlParams[0];
                    if (urlParams[1]) params['region_id'] = urlParams[1];
                    if (urlParams[2]) {params['type'] = urlParams[2];} else {params['type'] = 1;}
                    setBidtype(params['type']);
                }
            }
            
            if(params['division_id']){
                hash = '#json=1&division_id=' + params['division_id'] + '&model[general][region][]=' + params['region_id'] + '&type=' + params['type'];
                url += hash;
            }
        }
        if (hash) {
            if(hash == '#resume') {
                $('.bidtype.type-1').show()
                $('.bidtype.type-2').hide()
            } else if(hash == '#vacancies') {
                $('.bidtype.type-2').show()
                $('.bidtype.type-1').hide()
                $('.catalog_tabs .type-2').show()
                $('.catalog_tabs .type-1').hide()
            } else {
                if (menu.is('.edit')) {
                    url = '/offer/getdivisions?' + hash;
                }

                if (menu.is('.create')) {
                    menu.find('.type').hide();
                    menu.find('.select-items').show();
                }


                url = url.replace(/\?[0-9a-zA-Z_=&]*\#/, '#');
                url = url.replace('#', '?');
                var thisId = '';
                var thisType = 0;
                var tarr = hash.split('&');
                $.each(tarr, function(i) {
                    tarr[i] = tarr[i].split('=');
                    if (tarr[i][0] == 'division_id') {
                        thisId = tarr[i][1];
                    }
                    if (tarr[i][0] == 'type') {
                        thisType = parseInt(tarr[i][1]);
                    }
                });
                setBidtype(thisType);
                $('.search_divisions').show();

    //              create_offer_link(window.location.hash);

                menu.ajax = load_form(url, thisId);
            }
        }
    }

    if (menu.is('.create')) {


    } else if (menu.is('.search')) {
        $('.intro').hide();
        if (!window.location.hash) {

        }

    } else if (menu.is('.edit')) {
        var form = $('.catalog').find('form');
        form.on('submit', function () {
            if (!menu.is('.job')){
                if (!form.find('input[name="publish"]:checked').length){
                    alert(t('Выберите, открыть ли заявку сейчас, или оставить скрытой'));
                    return false
                }
            }
            var all_region_fields = true;
            var region_fields = form.find('.address_place select');

            if (!$(region_fields[0]).val() || $(region_fields[0]).val() == '') {
                all_region_fields = false;
            }
            if(!$(region_fields[1]).val() || $(region_fields[1]).val() == '') {
                if (!confirm(t('Вы уверены, что хотите создать заявку на весь регион?'))) {
                    return false;
                }
            }
            if (!all_region_fields) {
                alert(t('Укажите федеральный округ в базисе поставки'));
                return false;
            }
        });

    }

    var last_query;

    var on_form_submit = function(e) {
        e && e.preventDefault();
        var form = $(this);
        var dt = form.serializeObject();
        dt['json'] = 1;

        if (menu.is('.create') || menu.is('.edit')) {
            if (!menu.is('.job')){
                if (!form.find('input[name="publish"]:checked').length){
                    alert(t('Выберите, открыть ли заявку сейчас, или оставить скрытой'));
                    return false
                }
            }
            var all_region_fields = true;
            var region_fields = form.find('.address_place select');

            if (region_fields.length < 2) {
                all_region_fields = false;
            } else if ((!$(region_fields[0]).val() || $(region_fields[0]).val() == '') || (!$(region_fields[1]).val() || $(region_fields[1]).val() == '')) {
                all_region_fields = false;
            }
            if (!all_region_fields) {

                alert (t('Укажите федеральный округ и регион'));
                return false;
            }

        }

        var regions = new Array();
        $.each(form.find('.region select option:selected'), function(){
            if (parseInt($(this).val())) {
                regions.push($(this).val());
            }
        });
        dt['model[general][region][]'] = regions;
//      dt['region_id'] = '';
//      for (var key in dt) {
//          if (key == 'region_id') {
//              dt.splice(key, 1);
//          }
//      }
        search_regions = regions;
        location.hash = $.param(dt);
        create_offer_link($.param(dt), dt);

        var url = form.attr('action').split('?')[0];

        if (menu.is('.create') || menu.is('.edit')) {
            dt['json'] = 1;

            $.ajax({
                url: url,
                data: dt,
                type: form.attr('method').toUpperCase(),
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.status == 'saved') {
                        if (dt['publish'] == 1) {
                            if (menu.is('.job')) {
                                location.href='/job/list?own=1&offerType[]='+ dt['type'] + '&offerStatus[]=2&offerStatus[]=0&offerStatus[]=1';
                            } else {
                                location.href = '/offer/list?own=1&offerStatus[]=0';
                            }
                        } else {
                            if (menu.is('.job')) {
                                location.href='/job/list?own=1&offerType[]='+ dt['type'] + '&offerStatus[]=2&offerStatus[]=0&offerStatus[]=1';
                            } else {
                                location.href = '/offer/list?own=1&offerStatus[]=2';
                            }
                        }
                    } else if (data.status == 'invalid_user_input') {
                        var message = t('Форма заполнена некорректно:')+' \n';
                        $.each(data.errors, function() {
                            message = message + $(this)[0] + '\n'
                        })
                        alert(message);
                    } else if (data.status == 'can_not_create_offer') {
                        alert(data.message);
                    }
                }
            });
        } else {
                load({
                    url: url,
                    data: dt,
                    type: form.attr('method').toUpperCase(),
                    success: function(data) {

                      if (data && data.id) location.href = '/offer/view/id/' + data.id ;

                    }
                });
        }
    };
    menu.find('form').submit(on_form_submit);
    menu.find('.region-show').click(showRegions);
    var showRegions = function (e) {
        e.preventDefault();
        $(this).hide().parent().parent().find('.address_place').slideDown(200);
        $(this).parent().parent().find('.colon').hide();
        region_select_hidden = false;
    }

    menu.find('.catalog_tabs .type-tab').click(function () {
        $('.catalog_tabs  .type-tab').removeClass('active');
        $(this).addClass('active');
        if ($(this).is('.type-tab-1')) {
            menu.find('.type-2').fadeOut(300, function(){
                menu.find('.type-1').fadeIn(200);
            });

        } else {
            menu.find('.type-1').fadeOut(300, function(){
                menu.find('.type-2').fadeIn(200);
            });

        }
    });

    $(document).on('click', '.pager a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        url += '&json=1';
        load({
            url: url
        });
    });
});
$('.offerlist-menu').on('click', '.job-search', function () {
    window.location = $(this).attr('href');
    window.location.reload();
})
});