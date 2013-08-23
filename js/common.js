function formatTime(date) {
   var ret = ''
   ret += (date.getHours() < 10 ? '0' : '') + date.getHours();
   ret += ':';
   ret += (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
   return ret;
}


 function formatDate(datetime, format) {
    if (!datetime || datetime == '') return '';
    format || (format = {});


    var months = ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
    if (format == 'в') {
        months = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентебря', 'октября', 'ноября', 'декабря'];
    }
    var date;

    if (datetime instanceof Date) {
        date = datetime
    }else if (/^\d+$/.test(datetime)) {
        // unix datetime
        date = new Date(datetime);
    } else {
        date = mysqlTimeStampToDate(datetime);
    }

    var ret = date.getDate() + ' ' + months[date.getMonth()];
    if ((new Date()).getYear() != date.getYear()) {
        ret += ' ' + date.getFullYear();
    }
    if (format.time) {
        ret += ' в ';
        ret += formatTime(date);
    }


    return ret;
}


$(function() {




    var update_page = function() {
        var p = location.hash.replace(/^#/, '');
        var section = p.replace(/\//g, '_');
        if (section) {
            $('section').hide().filter('.' + section).show();
            $('a[href*="#"]').removeClass('current').filter('a[href$="#'+p+'"]').addClass('current');
        }
    };

    update_page();
    $(window).bind('hashchange', update_page);

    var html = function(sel, o) {
        this.cache || (this.cache = {});
        return this.cache[sel] || (this.cache[sel] = $(sel).html());
    };

    var copy = function() {
        $('*[data-copy]').each(function() {
            var el = $(this);
            el.html(html(el.data('copy'), html));
        });
    };
    copy();



    var ts = $('.registration form .type_selector');
    ts.find('.clicky span').click(function() {
        ts.toggleClass('person company');
    });


    var ts2 = $('.offer_create form .type_selector');
    ts2.find('.clicky span').click(function() {
        ts2.toggleClass('buy sell');
    });





    $('.registration form, .companies_1_staff form').each(function() {
        var f = $(this);
        var pass = f.find('.password');
        pass.keyup(function() {
            // из видмого копировать в оба
            if ($(this).is('.visible')) {
                pass.not(this).val(this.value)
            // из обычного копировать в видимое
            } else {
                pass.filter('.visible').val(this.value)
            }
        });

        f.find('.show-password input').change(function() {
            var show = $(this).is(':checked');
            pass.filter(':not(.visible)').toggle(!show);
            pass.filter('.visible').toggle(show);
        }).change();

    });

  

    $.fn.filter_with = function(func) {
        var params = $.makeArray(arguments).slice(1);
        return this.filter(function () {
            return func.apply(this, params);
        });
    };




    $.get('/js/catalog.txt', function(data) {

        /** parse **/

        var level = function(str) {
            var s = str.match(/^\s+/g);
            var r = s ? s[0].length : 0
            return r;
        };

        var parse = function(str) { return str.replace(/^\s*-\s*/,'') };
        var result = [];
        var current = { level: -1, obj: result };
        var depth = [];

        $.each(data.split('\n'), function(i,v) {
            if (!v.match(/\S/g)) return;
            
            var l = level(v);
            if (current.level == -1) current.level = l;

            if (current.level < l) {
                var o = [];
                current.obj.push(o);
                current.obj = o;
            } else if (current.level > l) {
                current.obj = depth[l] || result;
            }

            depth[l] = current.obj;
            current.level = l;
            current.obj.push(parse(v))
        });





        /** build **/




        var build = function(el, arr, level, options) {
            var list = options.list(el,arr,level);
            var prev;
            el.append(list);
            $.each(arr, function(i,v){
               if ($.isArray(v)) {
                   build(prev, v, level+1, options)
               } else {
                   prev = options.item(el,arr,level, i, v);
                   list.append(prev);
               }
            });
            
        }

        var a1 = '<a href="#">'
        var a2 = '</a>'

        var div = $('body > .c1 > div.catalog');

        build(div, result, 0, {
            list: function(e,a,l) { return $('<ul class="l'+ l + '">') },
            item: function(e,a,l,i,v) {
                v = v.split(' | ').join(a2 +' '+ a1);
                return $('<li>' +a1 + v + a2 +'</li>')
            }
        });






        $('section.companyOffers .form').each(function() {
            var form = $(this);
            form.find('a').live('click',function(e) { e.preventDefault(); });
            var cat = form.find('div.cat');


            build(cat, result,0, {
                list: function(e,a,l) { return $('<ul class="l'+ l + '">') },
                item: function(e,e,l,i,v) {
                    //v = v.split(' | ').join(a2 +' '+ a1);
                    if (l == 0) v = '';
                    return $('<li><div class=t>' + v +'</div></li>')
                }
            });


            cat.find('ul.l1 > li').appendTo(cat.find('ul.l1').first());
            //cat.find('ul.l1').appendTo(cat.find('ul.l0'));
            cat.find('ul.l1:empty').remove();



            cat.find('ul.l0 > li > .t').eq(0).text('Продать');
            cat.find('ul.l0 > li > .t').eq(1).text('Купить');
            cat.find('ul.l0 > li ').slice(2).remove();

            /******************/


            var table = $('section.companyOffers table');
            var rows = table.find('tr');


            var curr = 0;

            cat.find('li').live('click', function(e) {
                var el = $(this);
                if (el.is('li')) e.stopPropagation();

                var p = el.parents('ul').first();

                if (p.is('.expanded')) {
                    cat.find('li.current').removeClass('current');
                    el.siblings().not(el).hide();
                    el.addClass('current');
                    el.find(' > ul').addClass('expanded').find(' > li').show();
                    p.removeClass('expanded');
                } else {
                    p.find('> li').show();
                    el.find(' > ul li').hide();
                    p.addClass('expanded');
                }

                cat.find('.up').show();

                var m = p[0].className.match(/l(\d)/);

                var classes = ['.l0','.l1','.l2','.l3','.l4' ];

                if (m && m[1] ) {
                    var n = Number(m[1]);
                    if (n != curr) {
                        curr = n;

                        table.fadeOut(100, function() {
                            $('.d').addClass('s');

                            rows.filter(classes.slice(0, n + 1).join(',')).hide();
                            rows.filter(classes.slice(n + 1, classes.length).join(',')).show();

                            setTimeout(function() {
                                $('.d').removeClass('s');
                                table.show();
                            }, 300);
                        });

                    }




                }

         

            });

            /*
            cat.find('.up').click(function() {
                var c = cat.find('.current');
                c.siblings().show()
                c.find(' > ul > li').hide();
                c.removeClass('current selected');
                c.parents('.selected').first().addClass('current');

            });
            */

            cat.find('> ul').addClass('expanded');

        });






        /** interactivity **/


        var child_of = function(sel, p) {
            return $(this).parent().is(sel);
        };

        div.find('a').live('click', function(e) {
            e.preventDefault();
            var a = $(this)

            var r = div.data('result');
            if (r) {
                var li = a.parents('li');

                var data = {};

                $.each('l1 l2 l3 l4'.split(' '), function(i,v) {
                    data[v] = $.trim(li.filter_with(child_of, '.'+v).children('a').text());
                });

                r(data);
                div.hide();
            };
        });

        div.data('show', function() {
            div.data('result', null).show();
        });

        div.find('button.close').click(function(e) { div.hide() })
    });


    $('#add_staff, #add_news, #buying_form1, #buying_form2').each(function(){
        var form = $(this);
        var button = $('button[data-form="#'+form.attr('id')+'"]');

        form.find('button.close').click(function() {
            button.show();
        });
        
        form.find('button.save').click(function() {
            var r = form.data('result');
            if (r) {

                var d = {id: 2, date: new Date()};

                form.find(':input').each(function(i,v) {
                    var input = $(this)

                    if (this.type = 'date') {
                        d[input.attr('name')] = input.val()
                            .replace(/(\d+)-(\d+)-(\d+)/,'$3 $2 $1')
                            .replace(' 08 ', ' августа ')
                            .replace(' 09 ', ' сентября ');
                    } else {
                        d[input.attr('name')]=input.val();
                    }

                });
                
                r(d);

                button.show();
                form.hide();
            }
        });

        form.data('show', function() {
            button.hide();
            form.data('result', null).show();
        });
    });




    



    $('form').submit(function(e) { e.preventDefault() });


    $('.rows-editable').each(function(i,v) {
        var view = $(this);



        var s = view.find('.template').html().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        var c = view.find('.template')[0].className.replace(/(^| )template( |$)/, ' ');
        var t = _.template('"<div class="' + c + '">' + s + '</div>');

        // edit-row

        var remove_buttons =  view.find('button.remove');
        var add_button = view.find('button.add');

        var form = $($(add_button).data('form')).hide();

        var result =  function(data) {

                if (view.is('.one-row')) add_button.hide();
                view.find('.row:last').after($(t(data)).data('values', data));
        };

        view.data('result', result);

        remove_buttons.live('click', function(e) {
            e.preventDefault();
            
            add_button.show();
            $(this).parent().remove();
        });
        
        add_button.click(function(e) {
            e.preventDefault();

            

            form.each(function() {
                var s = form.data('show');
                s ? s() : form.show();
            }).data('result', result);
        });



        $.each(window.rows[view.attr('id')] || [], function(i,v) {
           result(v);
        });
    });


      $('.editable').each(function(i,v) {
        var view = $(this);

        var remove_buttons =  view.find('button.remove');
        var add_button = view.find('button.add');

        var form = $($(add_button).data('form')).hide();


        var t = view.find('.template');
        var s = t.html().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        var c = t[0].className.replace(/(^| )template( |$)/, ' ');
        t = _.template('"<div class="' + c + '">' + s + '</div>');



        var result = function(data) {

            view.find('.hide_on_result').hide();
            view.find('.show_on_result').show();

            add_button.show();
            view.find('.item:last').after($(t(data)).data('values', data));
        };

        add_button.click(function(e) {
            e.preventDefault();

            
            form.each(function() {
                form.find(':input').val('');
                var s = form.data('show');
                s ? s() : form.show();
            }).data('result', result);

            view.find('h5').show();
            $(this).hide();
        });


      });


   
    $(window).load(function() {
        var next = 1;
        var classes = ['', ' bg2',' bg3',' bg4'];
        var bg = $('.d2');

        bg.filter('.hidden').hide().removeClass('hidden');

        $(window).bind('hashchange', function() {



            if (next > 3) next = 0;

            bg.eq(next).hide().addClass('up').fadeIn(0, function() {
                bg.eq(next-1).hide();
                $(this).removeClass('up');
                next++;
            });

        });

    });


});
