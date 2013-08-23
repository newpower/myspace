if(typeof console === "undefined") {
    console = {
        log: function() { },
        warn: function() { },
        error: function() { }
    };
}


function text_case(s, i) {
    var words = s.split('|');
    if (!words[2]) words[2] = words[1];

    var w;
    if (i > 4 && i < 21) {
        w = words[2];
    } else {
        var m = i % 10;
        if (m == 1) {
            w = words[0];
        } else if (m > 1 && m < 5) {
            w = words[1];
        } else {
            w = words[2];
        }
    }

    return w ;
}

//function t (str) {
//    return str;
//}


$(function() {


    window.Helpers = {
        months:  [t('янв'), t('фев'), t('мар'), t('апр'), t('май'), t('июн'), t('июл'), t('авг'), t('сен'), t('окт'), t('ноя'), t('дек')],
		formatTime: function (date) {
		   var ret = ''
		   ret += (date.getHours() < 10 ? '0' : '') + date.getHours();
		   ret += ':';
		   ret += (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
		   return ret;
		},
        parseDate: function(d, format) {
            format || (format = {});

            var date;
            var ret;

            if (typeof d == 'object' && d.sec && d.usec) date = new Date(d.sec * 1000 + d.usec);

            if (date && !ret) ret = date.getDate() + ' ' + Helpers.months[date.getMonth()+1];

            if (date && (new Date()).getYear() != date.getYear()) {
                ret += ' ' + date.getFullYear();
            }

//			if (date && (new Date()).getYear() == date.getYear() && (new Date()).getMonth() == date.getMonth() && (new Date()).getDate() == date.getDate()) {
//                ret = 'Сегодня';
//            }

            if (date && format.time) {
                ret += t(' в ');
                ret += formatTime(date);
            }

            return ret;
        },

        parseDate1: function(d) {
            var ret = '';
            var r;

            var f = (typeof d == 'string' && (r = d.match(/(\d+)/g)) && r.length == 6)
            //if (!f) return ret;

//            ret = r[2] +' '+ Helpers.months[parseInt(r[1])-1] +' '+ r[0] +' '+ r[3] +':'+ r[4] +':'+ r[5];
            ret = r[2] +'.'+ r[1] +'.'+ r[0];


            return ret
        },

        parseDate2: function(d) {
            var ret = '';
            var r;

            var f = (typeof d == 'string' && (r = d.match(/(\d+)/g)) && r.length == 6)
            //if (!f) return ret;

//            ret = r[2] +' '+ Helpers.months[parseInt(r[1])-1] +' '+ r[0] +' '+ r[3] +':'+ r[4] +':'+ r[5];
            ret = r[2] +'.'+ r[1] +'.'+ r[0] +' '+ r[3] +':'+ r[4];


            return ret;
        },
		parseDate3: function(d) {
            var ret = '';
            var r;

            if (typeof d == 'object' && d.sec && d.usec) var date = new Date(d.sec * 1000 + d.usec);


			if(date) {
				rdate = date.getDate();
				// Remember: JS months are 0-indexed
				rmonth = date.getMonth()+1;
				if (rdate > 0 && rdate < 10) {
					rdate = '0' + rdate.toString();
				}
				if (rmonth > 0 && rmonth < 10) {
					rmonth = '0' + rmonth.toString();
				}
				ret = rdate + '.' + rmonth + '.' + date.getFullYear();
			}

            return ret;
        },
		parseDate4: function(d, format) {
			format || (format = {});

            var date;
            var ret;
            var r;

            var f = (typeof d == 'string' && (r = d.match(/(\d+)/g)) && r.length == 6)
            //if (!f) return ret;

			if (typeof(d) == 'string') {
				var date = new Date();
				r[1] = parseInt(r[1].replace('0', '')) - 1;
				date.setFullYear(r[0], r[1], r[2]);
				date.setHours(r[3], r[4]);

			} else if (typeof(d) == 'object' && d.sec && d.usec) {
				var date = new Date(d.sec * 1000 + d.usec);
			}

			if (date && !ret) ret = date.getDate() + ' ' + Helpers.months[date.getMonth()];

            if (date && (new Date()).getYear() != date.getYear()) {
                ret += ' ' + date.getFullYear();
            }

			if (date && (new Date()).getYear() == date.getYear() && (new Date()).getMonth() == date.getMonth() && (new Date()).getDate() == date.getDate()) {
                ret = t('сегодня');
            }

                ret += t(' в ');
                ret += Helpers.formatTime(date);

            return ret;
        },

        debounce: function(func, wait) {
            var timeout;
            return function() {
              var context = this, args = arguments;
              var later = function() {
                timeout = null;
                func.apply(context, args);
              };
              clearTimeout(timeout);
              timeout = setTimeout(later, wait);
            };
        },

		pluralize_js: function (num, t1, t2, t3) {
			var res = '';
			num = parseInt(num);
			var rest_100 = num % 100;
			if( 5 <= rest_100 && rest_100 <= 20) {
				res = t3;
			} else {
				var rest_10 = num % 10;
				if( 2 <= rest_10 && rest_10 <= 4) {
					res = t2;
				} else if (rest_10 == 1) {
					res = t1;
				} else {
					res = t3;
				}
			}
			return res;
		},
		
		format_price: function (sum) {
			var i = Math.floor(sum);
			var j = Math.round( (sum - i) * 100 );
            if (j==0) j='00';
			if (isNaN(i)) return '';
			return i + '.' + j;
		},
		
		convert_price_to: function (data, currency_code) {
			if (data === undefined || data == null) {
				return '';
			}
			if (currency_code == data.currency) {
				return data.price;
			}
			rate = get_rate_for_currency(currency_code);
			return data.price_in_rub / rate;
		},
		
		price: function (data, currency_code) {
			if (currency_code === undefined) {
				currency_code = user_profile().currency;
			}
			var value = Helpers.convert_price_to(data, currency_code);
			var r = Helpers.format_price(value) + ' ' + currency_code;
			return r;
		},
		
//		popup_close: function (target, popup) {
//			if (popup.className) popup = $(popup);
//			if (target.className) target = $(target);
//
//			eng();
//			function eng () {
//				if (target[0] == popup[0]) {
//					return
//				} else if (target[0] == $('body')[0]) {
//					popup.hide();
//					return
//				} else {
//					target = target.parent();
//					eng();
//				}
//			}
//		},
		popup_close_list: new Array(),
		to_close: function (popup) {
			if (popup.className) popup = $(popup);
			setTimeout(function () {window.Helpers.popup_close_list.push(popup)}, 50);
		},
        actualDate: function(date){

            return actualDate(date);
        },
        formatFloat: function (n) {
            n = n.toString();
            if (parseFloat(n)) n = n.replace('.', ',');
            return n;
        }
    };


	$(document).on('click', popup_closer);
	function popup_closer (e) {
//		callback || (callback = {});
		var target = $(e.target);
		var pl = window.Helpers.popup_close_list;
		var ntc = new Array();

		if (pl.length > 0) {
			eng();
		}
		function eng () {
			var pll = pl;
			var rec = true;
			if (target[0] == $('html')[0]) {
				rec = false;
				window.Helpers.popup_close_list = [];
				if (ntc.length > 0) {
					window.Helpers.popup_close_list.push(ntc);
				}
			}
			$.each(pll, function (i, el) {
				var popup = this;
				if (target[0] == popup[0]) {
					var f = pl.slice(0, i);
					var l = pl.slice(i+1);
					ntc = pl[i];
					pl = f.concat(l);
				} else if (target[0] == $('html')[0]) {
					popup.hide();
					rec = false;
				} else {

				}
			});

			if (rec) {
				target = target.parent();
				eng()
			} else return;
		}

	}


    if (jQuery.tmpl) {
        $.extend(jQuery.tmpl.tag, {
            'date': {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.parseDate($1));'
            },
            'datetime': {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.parseDate2($1, {time:1}));'
            },
			'date3': {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.parseDate3($1));'
            },
            'datetime_uf': {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.parseDate4($1));'
            },
            'price': {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.price($1));'
            },
            'actualDate': {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.actualDate($1));'
            },
            'formatFloat': {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.formatFloat($1));'
            },
            date1: {
                _default: { $1: "null", $2: "null"  },
                open: '__.push(Helpers.parseDate1($1));'
            }

        });
    }



    $.extend(jQuery.fn, {
        serializeObject: function() {
            var r = {};

            $.each(this.serializeArray(), function(i,v) {
               if (v.name.indexOf('[]') > 0) {
                 (r[v.name] || (r[v.name] = [])).push(v.value);
               } else {
                  r[v.name] = v.value;
               }
            });

            return r;

        },

        ajaxify: function(options) {
            return this.each(function() {
                var form = $(this);


                var opt = $.extend({}, {
                    func: $.ajax,

                    collect: function(form) {
                        return form.serializeObject();
                    },

                    dataType: 'json',


                    make_params: function(form) {
                        return [
                            form.attr('action'),
                            {
                                data:  form.data('options').collect(form),
                                dataType: form.data('options').dataType,
                                type: form.attr('method') ? form.attr('method').toUpperCase() : 'GET',
                                success: form.data('options').success

                            }
                        ];
                    },

                    success: function() {
                        console.log("success2", arguments);
                    }
                }, options || {});

                form.data('options', opt);

                form.on('submit', function(e) {
                    e && e.preventDefault();
                    opt.func.apply(form, opt.make_params(form));
                });
            });
        },

        ajaxify_link: function(options) {
            return this.each(function() {
                var a = $(this);

                options = $.extend({
                    data: function(a) { return { url: a.attr('href') }; },
                    before: function(a) { return true },
                    success: function() {}
                }, options || {});

                a.click(function(e) {
                   e.preventDefault();

                   if (options.before(a)) {
                       $.when($.ajax(options.data(a))).then(function() {
                           options.success.apply(a, arguments)
                       });
                   }
                })
            });
        }
    });


    $('#loader').ajaxStart(function() {
        $(this).fadeIn();
    }).ajaxStop(function() {
        $(this).fadeOut();
    });

    $('#mainpage').each(function() {

        $(this).find(':input').placeholder();

        var currentBG = 2;

		$('.walkingText').each(marquee);
		function marquee () {
			var stage = $(this).find('.c');
			var stageWidth = stage.width();
			var s = stage.find('.b');
			var scrollAmount = 1;
			var scrollSpeed = parseInt($(this).data('scrollspeed'));
			if (!scrollSpeed) scrollSpeed = 30;
			var scrollPos = 0;
			var pause = false;
			var blurCashe = false;

			stage.hover(scrollPause, scrollStart);

			$(window).blur(scrollStop);
			$(window).focus(scrollStart);
			$(window).resize(scrollStart);
			$(window).scroll(scrollStart);
			$(document).mousemove(function () {
				if (blurCashe == true) scrollStart();
			});
			if ($.browser.msie) {window.focus();}

			stage.css('overflow', 'hidden');
			s.css({
				'display': 'inline-block',
				'padding-right': stageWidth,
				'padding-left': stageWidth
			});
			scrollPos = stageWidth;
			stage.scrollLeft(scrollPos);

			scroll();
			function scroll () {
				if (pause == false) {
					if (scrollPos >= stage[0].scrollWidth - stageWidth) {
						reset();
					}
					stage.scrollLeft(scrollPos + scrollAmount);
					scrollPos = scrollPos + scrollAmount;
				}
				setTimeout(scroll, scrollSpeed);
			}
			function reset () {
				scrollPos = 0;
				stage.scrollLeft(scrollPos);
			}
			function scrollPause () {
				pause = true;
			}
			function scrollStop () {
				pause = true;
				blurCashe = true;
			}
			function scrollStart () {
				pause = false;
				blurCashe = false;
			}
		}

        $('h1').click(function(e) {
            if (++currentBG > 12) currentBG = 1;
            $('body')
                .removeClass('bg1 bg2 bg3 bg4 bg5 bg6 bg7 bg8 bg9 bg10 bg11 bg12')
                .addClass('bg'+currentBG);
        });

        $('.markets .analytics > div > em').click(function(e) {
            $(this).siblings('p').slideToggle();
        });

        var animate_indexes = function () {

//            $('.offers .indexes').each(function() {
                var t = $(this);
                var h = t.find('tr').not('.ttl').height();
                var ttl_h = t.find('tr.ttl').height();
                if (t.data('animating')) return;
                if (!h) return;
                if (!t.is(':visible')) return;

				function randomFromInterval(from,to){
					return Math.floor(Math.random()*(to-from+1)+from);
				}

				var trs = t.find('tr');
				var ttls = t.find('tr.ttl');
				var start_pos = randomFromInterval(0, trs.length) * h;
				if (t.closest('.scroller-block').is('.prices-scroller')) {
					var ttls_ind = [];
					ttls.each(function(){
						ttls_ind.push($(this).index());
					});
					var ttl_start = randomFromInterval(0, ttls_ind.length);
					start_pos = ttls_ind[ttl_start] * h;
				}
				var top = parseInt(t.css('margin-top'));
				if (!top) {
					t.css('margin-top', -start_pos + 'px');
				}

                var c = - Math.floor(parseInt(t.css('margin-top')) / h);

                if (!parseInt(t.css('margin-top'))) c = 1;
                var c_visible = 5;

                var time = [1000, 2000, 4000];

                var f = function() {
                    t.data('animating', false);
                    if (!t.is(':visible')) return;
					if (c+1 + c_visible >= t.find('tr').length) {
						t.append(t.find('tr').clone())
					}
                    t.animate({
                        'margin-top': - c * h + 'px'
                    },{
                        duration: 'slow',
                        complete: function() {
                            c++;


                            if (t.is(':visible')) {
                                t.data('animating', true);
                                setTimeout(f, time[Math.floor(Math.random() / .34)]);
                            }
                        }
                    });

                };

                if (t.is(':visible')) f();
//            });

        }
//        animate_indexes();
		$('.offers .indexes').each(function() {
			animate_indexes.apply(this);
		});

		$('#mainpage .offers').on('click', '.scr-tabs span', function(e){
			var wr = $(this).closest('.scroller-container');
			var tabs = wr.find('.scroller-block');
			var ttls = wr.find('.scr-tabs span');
			var cl = this.className;
			cl = cl.split('-')[0] + '-' + cl.split('-')[1];

			var tab = wr.find('.'+cl);
			tabs.hide();
			tab.show();
			ttls.removeClass('active');
			$(this).addClass('active');
//			animate_indexes();
			animate_indexes.apply(tab.find('.indexes')[0]);
		});

		var openCatMenu = function () {
//			$('.photopromo-wr').addClass('opened');
//			$('.photopromo-wr').animate({height: 244}, 300);
			$('#catalog2lev').slideDown(300, function () {
				buildCatalogScroll.apply(this);
			});
		}
		var closeCatMenu = function () {
//			$('.photopromo-wr').removeClass('opened');
//			$('.photopromo-wr').animate({height: 131}, 300);
			$('#catalog2lev').slideUp(300);
		}
		var posCatMenu = function (ul, lev1act) {
//			var wr = $('.photopromo-wr');
			var lev1 = $('#catalog1lev ul');
			var lev1_width = lev1.width();
			var lev1act_width = lev1act.innerWidth() + parseInt(lev1act.css('margin-right'));
			var lev1act_index = lev1act.index();
			var lev1act_offset = lev1act_index * lev1act_width;

			var ul_width = ul.width();
			var ul_length = ul.find('li').length;
			var ul_li_index = Math.ceil(ul_length/2)-1;
			var ul_li_width = $(ul.find('li')[0]).innerWidth() + parseInt($(ul.find('li')[0]).css('margin-right'));
			var ul_inner_offset = ul_li_index * ul_li_width;
			var ul_offset = lev1act_offset - ul_inner_offset;

			ul.css('margin-left', 0);

			if (ul_width >= lev1_width) return;
			if (ul_offset < 0) return;

			if (ul_offset + ul_width > lev1_width) ul_offset = lev1_width - ul_width;

			ul.css('margin-left', ul_offset);
		}

		$('#catalog1lev').on('click', 'li', function(e){
			e.preventDefault();
			var anim = 'slide';
			var lev1act = $(this);
			var id = $(this).attr('id').split('_')[1];

			var lev2next = false;
			var lev2act = $('#catalog2lev').find('ul.active');
			if (lev2act.length == 1) {
				lev2act.removeClass('active');
			}

			$('#catalog2lev').find('ul').each(function() {
				var $this = $(this);
				var parent_id = $this.data('parent');
				if (parent_id == id && $this.find('li').length > 0) {
					lev2next = $this;
//					anim = 'fade';
				}
			});

			if (lev2act.length == 0) {
				if (lev2next.length == 1) {
					openCatMenu();
					lev2next.addClass('active').show();
//					posCatMenu(lev2next, lev1act);
				}
				return;
			}

			if (lev2next.length == 1) {
				lev2act.slideUp(300, function () {
//					posCatMenu(lev2next, lev1act);
					lev2next.css('left', '0px');
					lev2next.addClass('active').slideDown(300, function() {
						buildCatalogScroll.apply($('#catalog2lev')[0]);
					});
				});
				return;
			}

			if (!lev2next) {
				lev2act.slideUp(300);
				closeCatMenu();
			}
		});

		var buildCatalogScroll = function () {
			var $el = $(this);
//			console.log('build', this);

			$el.off('mouseenter mouseleave mousemove');
			$el.find('ul:visible').css('left', '0px');

			var catalogScrollSpeed = parseInt($(this).find('ul:visible').data('speed'));
			if (!catalogScrollSpeed) catalogScrollSpeed = 1;
			clearInterval(catalogScrollInt);
			var catalogScrollInt = 0;
			var catalogScrollSpeedVar = 5;

			$(this).on('mouseenter', function () {

				var container = $(this);
				var container_width = container.width();
				var ul = container.find('ul:visible');
				var ul_width = ul.width();
				var speed = catalogScrollSpeed;
				clearInterval(catalogScrollInt);

				var arrows = container.find('.arrow');
				arrows.hide();
				arrows.fadeIn(200);

//				console.log('mouseenter', ul[0]);

				var catScroll = function () {
					var pos = parseInt(ul.css('left'));
//					console.log('catScroll', pos);

					var c = {
						0: -6,
						1: -5,
						2: -4,
						3: -2,
						4: 0,
						5: 0,
						6: 2,
						7: 4,
						8: 5,
						9: 6
					}

					var s = speed*c[catalogScrollSpeedVar];


					pos = pos - s;
					if (ul_width <= container_width) return;
					if (pos <= (ul_width - container_width)*-1) pos = (ul_width - container_width)*-1;
					if (pos > 0) pos = 0;
					ul.css('left', pos);
				}

				catalogScrollInt = setInterval(catScroll, 20);
			});

			$(this).on('mouseleave', function () {
//				console.log('mouseleave');
				clearInterval(catalogScrollInt);
				catalogScrollInt = 0;
				catalogScrollSpeedVar = 5

				var arrows = $(this).find('.arrow');
				arrows.stop().fadeOut(200);
			});

			$(this).on('mousemove', function (e) {
				var container = $(this);
				var container_width = container.width();
				var container_offset = container.offset().left;
				var X = e.pageX;
				var container_x = X - container_offset;
				var pers = Math.floor(((container_x / container_width) * 10));
				catalogScrollSpeedVar = pers;
			});
		}

		$('#catalog1lev').each(function(){
			buildCatalogScroll.apply(this);
		});

    });


    $('.catalog.job').on('click', '#hide_j', function () {
        if ($(this).is(':checked')) {
            $('#publish').val('0');
        } else {
            $('#publish').val('1');
        }
    });

    $('#offer-view').each(function() {
        var view = $(this);

        view.find(' .buttons .delete').click(function(e) {
            if (!confirm($(this).attr('confirm'))) e.preventDefault();
        });

        view.find('.buttons .archive, .buttons .open').ajaxify_link({
            before: function(a) {
                return confirm(a.attr('confirm'))
            },

            success: function(data) {
            	try {
	            	data = eval('(' + data + ')');
	            	if (data.status == 'error') {
	            		alert(data.message);
	            		return;
	            	}
	            } catch (err) {}
            	$(this).remove();
				if ($(this).attr('newstatus')) {
					$('#offer-view .statuses .status').text($(this).attr('newstatus'));
				}
				$('.is_commit_request').hide();
				$('form .failed-offer').show();
            }
        });
    });


    $('#offer-search-data').each(function() {
        $('#offer-search-data-table-template').template('catalog_data_table_template');
        var place = $(this);
		var user_filter = 0;

        var render_lines = function(rows, cols, type, count, params) {
        	if (typeof params == 'undefined') {
        		params = {};
        	}
            var l = $.tmpl('catalog_data_table_template', { rows: rows, cols: cols, type: type, count: count, params: params});
            return l;
        };

		var render_user_filter = function (user_name, user_id) {
			var form = $('div.form form');
			var u_block = form.find ('.user-filter-name');
			var hidden = form.find(':hidden[name=user_id]');
			if (u_block.length == 0) {
				u_block = $('<span class="user-filter-name"><i class="t">'+t('Заявки участника ')+'</i></span>').append(
					'<i class="n">' + user_name + '</i> '
				).append(
					$('<a class="ajax"></a>').attr('href', '#').html(t('показать заявки всех участников')).click(function (e) {
						e.preventDefault();
						$(this).closest('span').remove();
						form.find(':hidden[name=user_id]').remove();
						user_filter = 0;
						form.submit();
					})
				)
//				.append(
//					hidden
//				)
				.appendTo(form);
			}
			if (hidden.length == 0) {
				hidden = $('<input type="hidden">').attr('name', 'user_id');
				hidden.val(user_id).appendTo(form);
			}
			user_filter = 1;
		}

        $(document).on('update_catalog_data', function (e, data) {

//			var html = render_lines(data.list,data.fields, data.type, data.count, data.params);

			var html = $(data.search_result);
			place.html(html);
			if (data.pager) {
				var pager = $('<div class="pager">' + data.pager + '</div>');
				place.append(pager);
			}
			if (window.location.hash) {
//				var larr = window.location.hash.split('&');
//				var user_id;
//				var user_name;
//				$.each(larr, function (i, item) {
//					var kv = item.split('=');
//					if (kv[0] == 'user_id') {
//						user_id = parseInt(kv[1]);
//					}
//				});
//				$.each(data.list, function (i, l) {
//					if (data.list[i].user_id == user_id) {
//						user_name = data.list[i].user;
//					}
//				});
//				if (user_id && user_name) {
//					render_user_filter(user_name, user_id);
//				}
			}
			$('td.photos a').fancybox({ cyclic: true });
			$('#create_this_offer').show();
        });
		$(document).on('click', '.user-filter-link a', function (e) {
			e.preventDefault();
			var form = $('div.form form');
			var user_id = $(this).data('userId');
			var user_name = $(this).data('userName');
			render_user_filter(user_name, user_id);
			form.submit();
		});
		$(document).on('mouseenter', '#offer-search-data tr', function(e) {
			if (user_filter == 0) {
				var wr = $(this).find('.user-wr');
				if (wr.length != 0) {
					var top = wr.parent().offset().top - $('#offer-search-data').offset().top;
					wr.find('.user-filter-link').css('top', top).fadeIn(300)
						.find('.inner').css('min-height', $(this).height()-11);
				}
			}
		});
		$(document).on('mouseleave', '#offer-search-data tr', function(e) {
			if (user_filter == 0) {
				var wr = $(this).find('.user-wr');
				if (wr.length != 0) {
					wr.find('.user-filter-link').stop().fadeOut(300, function(){
						$(this).css('opacity', '1');
					});
				}
			}
		});
    });

    $('#registration').each(function() {
        $(this).find('input[placeholder]').placeholder();
    })


    $('#registration form .type_selector').each(function() {
        var ts = $(this);

        ts.find('.clicky span').click(function(e) {
			e.stopPropagation();
            ts.toggleClass('person company');
	        if (ts.hasClass('person')){
		        ts.find('input.private').val('1');
	        } else {
		        ts.find('input.private').val('0');
	        }
        });
    });


     $('#registration form, .companies_1_staff form').each(function() {
        var f = $(this);
         NumberMask.set($('input[name="User[phone]"]'), { short: false})


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

           // setTimeout(function() {
                pass.filter(':not(.visible)').closest('label').toggle( !show);
                pass.filter('.visible').closest('label').toggle( show);
           // }, 10)
        }).change();
    });

	$('#registration form, #profile form').each(function () {
//		$('#company-info-template').template('company_info_template');
		var f = $(this);
		var inn_inp = f.find('#Company_inn');


		var inn_check = function () {
			var inn = inn_inp.val();
			var url = '/company/getCompany?inn=' + inn;
			if (inn.length > 9) {
				f.find('#User_is_private_person').val('0');
				$.ajax({
					url: url,
					dataType: 'json',
					type: 'get',
					global: false,
					success: function (resp) {
						if (resp.company != null) {
							var l = '';
							if (f.is('#create-company')) {
								l += '<div class="txt"> <a href="/company/view/id/' + resp.company.id + '">' + resp.company.name + '</a>'
							} else {
								l += '<div class="txt">' + resp.company.name ;
							}
							if (resp.company.description) {
								l += ' <span>' + resp.company.description + '</span></div>';
							} else {
								l += '</div>';
							}
							if (resp.company.media) {
								l = '<div class="img">' + resp.company.media + '</div>' + l;
							}
	//						var l = $.tmpl('company_info_template', { name: resp.company.name, description: resp.company.description , media: resp.company.media});
							$('#company-place').html(l);
							$('.request-company-membership').slideDown(200);
							f.find('#company_to_join').val(resp.company.id)
							$('.company-fields').slideUp(200);
							$('.opf-list, .company-name').hide();
                            inn_inp.data('allowSubmit', 'false');
						} else {
							$('.request-company-membership').slideUp(200);
							$('.company-fields').slideDown(200);
							f.find('#company_to_join').val('');
							$('.opf-list, .company-name').show();
                            inn_inp.data('allowSubmit', 'true');
						}
					}
				});
			} else {
				$('.request-company-membership').slideUp(200);
				$('.company-fields').slideUp(200);
				f.find('#company_to_join').val('');
				$('.opf-list, .company-name').hide();
				f.find('#User_is_private_person').val('1');
                inn_inp.data('allowSubmit', 'false');
			}
		}

		inn_inp.on('change keyup', inn_check);

		f.find('#user_company_membership_req').on('change', function () {
			if ($(this).is(':checked')) {
				$('.company_membership_request_inf').show();
				$('#btnCreateMemberRequest').show();
			} else {
				$('.company_membership_request_inf').hide();
				$('#btnCreateMemberRequest').hide();
			}
		});

		f.find('.change-company-tr').on('click', function () {
			$('.request-company-membership').slideUp(200, function () {
				$(this).removeClass('visible');
			});
			inn_inp.parent('label').slideDown(200);
			$(this).hide();
		});
	});

	$('#profile.form .type_selector').each(function() {
        var ts = $(this);
        ts.find('.clicky span').click(function() {
            ts.toggleClass('person company');
	        if (ts.hasClass('person')){
		        ts.find('input.private').val('1');
	        } else {
		        ts.find('input.private').val('0');
	        }
			ts.closest('.form').toggleClass('person-type company-type')
        });
    });


    $('.messages').each(function() {


        $('#message-item-template').template('message_item_template');

        var messages = $(this);
        var uid = this.id.match(/with-(\d+)/)[1];
        var data = window['messages_with_' + uid];

        var last_update = 0;

		var recieved_form = '';

		messages.on('click', '.show-messages span', function () {
			var shm = $(this).parent();
			if (!shm.is('.opened')) {
				shm.addClass('opened')
					.next('.items').find('.messages-section').slideDown('300');
				var m_count = shm.next('.items').find('.item')
//					.filter(function(){
//						return !$(this).is('.accepted');
//					})
					.length - 1;
				shm.find('.m-count').text(' ' + (m_count == 1 ? '' : m_count) + window.Helpers.pluralize_js(m_count, t(' предыдущее'), t(' предыдущих'), t(' предыдущих')) + ' ' + window.Helpers.pluralize_js(m_count, t('сообщение'), t('сообщения'), t('сообщений')));
			} else {

				shm.removeClass('opened')
					.next('.items').find('.messages-section').slideUp('300');
			}
		});

		messages.on('click', '.fields_switch span', function() {
				var t = $(this)
				if (t.is('.selected')) return;

				var all = t.is('.all');
				$(this)
					.addClass('selected')
					.siblings().removeClass('selected')
					.closest('.request-bid').toggleClass('show_all', all);
		});

        messages.on('click', '.insert a', function (e) {
            e.preventDefault();
            $(this).hide().closest('.insert').find('select').show();
        });

        messages.on('change', '.insert select', function (e) {
            var a = $(this).val();
            if ($(this).is('.my-resume')) {
                a = t('Мое резюме: ') + a;
            } else {
                a = t('Моя вакансия: ') + a;
            }
            $(this).closest('form').find('textarea[name="message"]').text(a);
        });

		var make_commit = function(c, options) {
			if (c.is('.made')) return;
			c.addClass('made');

			options || (options = {});

			var types = ['text','int','list','date','region', 'basis'];

			//fields

			c.find('h3').text(options.h).append($('<div class="fields_switch"><span class="ajax changed selected">'+t('измененые')+'</span><span class="ajax all">'+t('все')+'</span></div>'))

			c.children('div').each(function() {
				var item = $(this);
				var type='';
				if (item.is('.region')) {
					type='region';
					item.addClass('field');
					item.find('.address_place').hide().addClass('hidden-by-default');
					val = item.find('.v').hide().find('.region-show').text();
					if (val == '' || val == t('выберите')) {
						val = t('не указано');
						item.find('.u').hide().addClass('hidden-by-default');
					}
					var val_cont = item.find('label').after($('<span class="val"></span>').text(val));
					val_cont = item.find('.val');
					if (item.closest('form').length != 0) {
						val_cont.html('<span class="ajax">' + val + '</span>');
					}
					val_cont.click(function(e){
						e.preventDefault();
						if ($(this).closest('form').length != 0) {
							$(this).next('.v').click();

							var basis_f = $(this).closest('form').find('.basis');
//							item.find('.t :input').attr('checked', 'checked');
							basis_f.find('.hidden-by-default').show();
							basis_f.find('.val').hide();
						}
					});
				} else if (item.is('.basis')) {
					type = 'basis';
					item.addClass('field');
					item.find('.basis-select').hide().addClass('hidden-by-default');
					val = item.find('.v').hide().find('.basis-show').text();
					if (val == '' || val == t('выберите')) {
						val = t('не указано');
						item.find('.u').hide().addClass('hidden-by-default')
					}
					item.find('label').after($('<span class="val"></span>').text(val).click(function(){
						if ($(this).closest('form').length != 0) {
							$(this).closest('.basis').parent().find('.region .val').click();
						}
					}));
				} else {
					type = _.intersection(this.className.split(/\s+/),types)[0];


					if (type) {

						item.addClass('field');


						if (type == 'date') {
							var eld = item.find('input:text');
							eld[0].id = eld[0].id + Math.random().toString().replace('0.', '');
							eld.datepicker({
								dateFormat: 'dd.mm.yy',
								onSelect: function ( selectedDate ) {
									eld.prev('.val').text(selectedDate);
								}
							});
						}



						var val = item.find(':input').hide().addClass('hidden-by-default').map(function() {
							var el = $(this);
							var val = el.val();

							if (type == 'list') {
								val = el.find('option[value='+val+']').text();
							}

							if (type == 'region') {
								val = el.find('.v').find('.region-show').text();
							}

							return val;
						}).get().join(', ')

						if (val == '') {
							val = t('не указано');
							item.find('.u').hide().addClass('hidden-by-default')
						}

						item.find('.address_place').hide().addClass('hidden-by-default')

						item.find('label').after($('<span class="val"></span>').text(val))


						if (options.editable) {
							item.append($('<label class="t"><input type="checkbox" /> '+t('изменить')+'</label>'));
						}
					}
				}
			});

//            if (!c.find('> .changed_all_time').length) c.find('h3 span.all').click();
            if (c.closest('.last').length) c.find('h3 span.all').click();

            if (options.accepted) {
                c.find('h3 span.all').click()
                c.find('h3').remove()
            }


		};



        var req_status = 0;



        var toggle_commit = function(data) {


            if (data.request_status && data.request_status != "0") {

                messages.find('form .commit').hide();
                messages.closest('.req').addClass('accepted');
                req_status = data.request_status;

                $('div.commit').remove();

                if (req_status) {
//                    messages.find('form .archive-offer').show();
                }
            } else {
                messages.find('form div.commit').show();
            }
        };

        var parse_links = function (text) {
            return text;
        };

        var render = function(d) {

            if (d.list) {

                data = d;
                data.uid = uid;

                data.list = $.grep(data.list, function (v) {
                    messages.find('#message' + v.id).remove();
                    return true;
                });


                if (data.list.length) {
//					messages.find('.show-messages').show();
                    $.each(data.list, function (i, item) {
                        if (item.last_update > last_update) last_update = item.last_update;

                        if (item.is_commit_request == '1' &&
                            item.form &&
                            item.form.length
                            ) {
                            messages.find('div.commit .request-bid').removeClass('made').html(item.form)
                        }
                    });

                    var message_item = $.tmpl('message_item_template', data);
//                    message_item = parse_links(message_item);
                    message_item.insertBefore(messages.find('.items .last'));
                }

            }

            messages.find('.item .request-bid').each(function() {
                make_commit($(this), {
                    h: t('Предлагаемые условия'),
                    accepted: $(this).closest('.item').is('.accepted')
                });
            });


            make_commit(messages.find('div.commit .request-bid'),{ h: t('Предложить условия'), editable:true});


        }

        if (data) {
            toggle_commit(data)
            render(data);
			if (data.list.length) {
				var hm_count = 0;
				$.each(data.list, function (i, li) {
//					if (li.status != 1) {
						hm_count++;
//					}
				});
				if (hm_count > 0) hm_count--;
				if (hm_count != 0) {
					messages.find('.show-messages').show()
						.find('.m-count').text(' ' + (hm_count == 1 ? '' : hm_count) + window.Helpers.pluralize_js(hm_count, ' предыдущее', ' предыдущих', ' предыдущих') + ' ' + window.Helpers.pluralize_js(hm_count, 'сообщение', 'сообщения', 'сообщений'));
				}
			}
        }



        var update = function() {

            if (data) {
                $.ajax('/offer/getMessages', {
                    global: false,
                    data: {
                        request_id: data.request_id,
                        last_update: last_update
                    },
                    dataType: 'json',
                    success: function(d) {
                        if (d) {
							d.showSection = 'show';
                            toggle_commit(d);
                            render(d);

                        }
                    }
                });
            }
        }

		var change_offer_status = function (s) {
			messages.find('.is_commit_request').hide();
			if (s == 8 || s == 16) {
				if (s == 16) messages.find('form .withdraw-offer').show();
				if (s == 8) messages.find('form .other-commit-offer').show();
				$('.statuses .status').text(t('Несостоявшаяся'));
				$('.buttons .archive').remove();
				messages.find('.last .commit').hide();
			} else if (s == 7 || s == 6) {
				$('.statuses .status').text(t('Закрытая'));
				$('.buttons .archive').remove();
				messages.find('.last .commit').hide();
				messages.find('form .archive-offer').show();
			}
		}

//        setInterval(update, 10 * 1000);
		$(window).bind('faye_notify', function (e, d) {
//			alert(d.type);
			if (d.type == 1 || d.type == 4 || d.type == 6 || d.type == 7)update();
			if(d.type == 16 || d.type == 8 || d.type == 6 || d.type == 7) {
				change_offer_status(d.type);
			}
		});

        window.update_messages = update;

		messages.find('div.commit')

			.on('click', '.field .val', function () {
				var item = $(this).closest('.field');
				if (item.is('.date')) {
//					item.find('.hidden-by-default').show();
//					$(this).hide();
					item.find('input:text').datepicker('show');
				} else {
					item.find('.t :input').attr('checked', 'checked');
					item.find('.hidden-by-default').show();
					$(this).hide();
				}

			})

			.on('change', '.t :input', function() {
				var item = $(this).closest('.field');
				var checked = $(this).is(':checked');
				item.find('.hidden-by-default').toggle(checked)
				item.find('.val').toggle(!checked)

			}).find('.field .val').attr('title', t('Изменить'));


        messages.find('form').ajaxify({
            success: function(d) {
				d.showSection = 'show';
                render(d);
                messages.find('form textarea').val('');
				if (d.status == 'error') {
//					alert(d.message);
				}
            },

            collect: function(f) {
                var d = f.serializeObject();
                d.last_update = parseInt(last_update);
                return d;
            }
        });

        messages.find('a.button.is_commit_request').click(function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var rb = form.find('.request-bid');
            form.find('input[name = is_commit_request]').attr('checked', 'checked').change();
        });

        messages.find('input[name = is_commit_request]').change(function(){
            if ($(this).is(':checked')){
                $(this).closest('form').find('.request-bid').slideDown();
                $(this).closest('label').hide();
            } else {
                $(this).closest('form').find('.request-bid').slideUp();
            }
        });
    });


    if ($.fancybox) {
        $('a.fancy').fancybox({ cyclic: true });

        $('.photos a').fancybox({ cyclic: true });

        $('#gallery-item .list a').fancybox({ cyclic: true });
    }


    $('#user-search').each(function() {
        $('#user-search-data-table-template').template('user_data_table_template');

        var search = $(this);

        var input = Helpers.debounce(function() {
               $(this).closest('form').submit();
        }, 500);

        search.find('form').each(function() {
            var f = $(this);
            f.ajaxify({
                collect: function(form) {
//                    console.log("collect", form);
                    return form.serializeObject();
                },
                success:function (data) {
                    search.find('.data').html(render(data));
                }
            });
        });

        search.on('change click keyup', ':input', input);

        search.find('.toggle-search span').click(function() {
            $(this).hide().siblings().show()
            search.find('form').toggle();
        });



        var sort_field = search.find('input[name=sort_field]');
        var sort_order = search.find('input[name=sort_order]');
        search.on('click','th a', function(e) {
            e && e.preventDefault();
            var d = $(this).data() || {}

            if (sort_field.val() == d.sortField) {
                sort_order.val(parseInt(sort_order.val()) * -1)
            } else {
                sort_order.val('-1');
            }

            sort_field.val(d.sortField)
            search.find('form:visible').submit()

        });

        var render = function(data) {
            var l = $.tmpl('user_data_table_template', data);
            return l;
        };

    });


    $('form.qreq').each(function() {
        var form = $(this);

        form.find('.close').click(function() {
            form.fadeOut();
        });

        var center = function() {
            form.animate({ 'margin-top': '-' + (form.height() / 2 + 100) }, 'slow');
        };

        form.submit(function() {

            $.ajax({
            	url: form.attr('action'),
            	dataType: 'json',
            	type: 'post',
            	data: form.serialize(),
            	success: function(data) {
            		if(data.status == 'success') {
            			form.find('input[type=submit]').fadeOut();
			            form.find('.result').slideDown();

			            center();

			            setTimeout(function() {
			                form.fadeOut();
			            }, 3000);
            		} else {
            			alert('error');
            		}
            	}
            });

            return false;
        });

        form.find('.list .add').click(function() {
            var new_item = form.find('.item:first').clone();
            new_item.find('input').val('');
            new_item.insertBefore(this);
            new_item.slideDown();

            center();
        });

        form.on('click', '.item .delete', function() {
            $(this).closest('.item').slideUp().not(':first').remove();

            center();
        });

        form.data('show', function() {
            form.fadeIn();
            center();
        });


    });


    $(".datepicker").each(function () {
        var dis = $(this);
        $(this).datepicker({
            onSelect:function (dateText, inst) {
				var loc_split = location.href.split('?');
                if (dis.closest('.banners_form').length == 0)
                    location.href = loc_split[0] + '?day=' + dateText;
            }
//            defaultDate:'2222'
        });
    })


    $('#profile-friends').each(function() {
        var page = $(this);

        page.find('.button').ajaxify_link({
            success: function() {
                if ($(this).is('.delete, .reject')){
	                $(this).closest('li').addClass('deleted').slideUp(function(){
		                var size = $(this).closest('div').find('li').not('.deleted').size();
		                if ($(this).closest('div').hasClass('friends') && size == 0){
			                item = $('<li></li>');
			                item.append($('<span class="empty"></span>').text(t('На этой странице вы будете видеть партнеров, с которыми у вас установлены отношения, находите и добавляйте партнеров в нашей системе сразу или после заключения сделки.')));
			                $(this).closest('ul').append(item);
		                } else if ($(this).closest('div').hasClass('unaccepted') && size == 0){
			                $(this).closest('div').hide();
		                };

	                });
                };
                if ($(this).is('.accept')){
	                $(this).closest('li').appendTo('.friends ul');
	                var href = $(this).siblings('.reject').attr('href').replace(/rejectFriend/g, 'deleteFriend');
	                $(this).siblings('.reject').text(t('Удалить')).attr('href',href);
					$('.friends ul').find('.empty').closest('li').remove();
	                if ($('.unaccepted ul li').size() == 0){
		                $('.unaccepted').remove();
	                }
	                $(this).remove();
                }
            }
        })

    });

    if ($.gritter) {
        $.extend($.gritter.options, {
            position: 'top-left',
        	fade_in_speed: 'medium',
        	fade_out_speed: 300//,
        //	time: 30000
        });

        $('#notification-template').template('notification-template');

        var parent_menu = $('#menu1 .main > ul');

        parent_menu.on('click', 'a.show', function(e) {
            e.preventDefault();
            $(this).parent().toggleClass('active').find('.list').toggle();
        })

        var render_menu = function(list, count) {
            parent_menu.find('.notification-menu').remove();
            $.tmpl('notification-template', { list: list, count: count })
                .addClass('notification-menu').appendTo(parent_menu);
        };


        var last_id = 0;

        var action_messages = {
            'accept': t('принял ваши условия'),
            'deny': t('отверг ваши условия'),
            'fix': t('предлагает зафиксировать условия')
        };



        var title_reg = /<span class="user">([^<]*)/;
        var img_reg = /<img src="([^"]*)" >/;
        var show_notifications = function(list) {

            var j = 0

            $.each(list, function (i,v) {

//				if (v.type==16 || v.type==8) {
//					v.url = '';
//				}

                if (Number(v.id) <= last_id ||
                    (location.pathname == v.url && v.type != 16 && v.type != 8)
                    ) return;

                var title;
				if (v.params && v.params.user) {
					title = v.params.user;
				} else {
					title = '';
				}
                var image
				if (v.params && v.params.user_media) {
					image = v.params.user_media;
				} else {
					image = '';
				}
                var text = v.text;
                if (v.params) {
                    text = v.params.action + ' ';
                    if (v.params.message) text += '"'+ v.params.message.substring(0, 150) +'" '
                    text +=  '<a href="'+v.url+'">' + (typeof v.params.object == 'undefined' ? t('посмотреть подробнее') : v.params.object) + '</a>';
                }

                setTimeout(function() {
                    var id = $.gritter.add({
                        title: title,
                        text: text,
                        image: image,
                        time: 30000
                    });
                 },  600 * j++)
            });

        };


        var get_notifications = function(options) {
            options || (options = {});

            var data = {last_id: last_id}
            if (options.first) data.url = location.pathname;

            $.ajax({
                url: '/profile/getNotifications2',
                data: data,
				global: false,
                dataType: 'json',
                success: function(data) {
                    if (!data) data = {};
                    if (!data.list) data.list = [];

                    $.each(data.list, function(i, v) {
                        try {
                            v.params = JSON.parse(v.text);
                        } catch(e) {
                            //console.log('json', e, v.text)
                        }
                    });

					if (data.old_unread.length) {
						$.each(data.old_unread, function(i, v) {
							try {
								v.params = JSON.parse(v.text);
							} catch(e) {

							}
							if (i == data.old_unread.length - 1) {
								v.separator = 1;
							}
						});
					}

                    if (!options.first) {
                        show_notifications(data.list);
						var title_alert = t('У вас ') + data.unread_count + ' ' + window.Helpers.pluralize_js(data.unread_count, t('новое уведомление'), t('новых уведомления'), t('новых уведомлений'));
//						var title_alert ='У вас новое сообщение';
						$.titleAlert(title_alert
								, {
							interval: 500,
							duration: 0,
							stopOnFocus: true,
							stopOnMouseMove: true,
							requireBlur: true
						});
                    }

                    if (data.list.length || data.old_unread.length || options.first) {
						var total_list = data.list.reverse();
						if (data.old_unread.length) {
							total_list = total_list.concat(data.old_unread.reverse());
						}
                        render_menu(total_list, Number(data.unread_count || 0))
                    }

                    last_id = data.last_id;
                },
                global: false
            })
        }

        //setInterval(get_notifications, 3000);
        get_notifications({first:true});

	$(function() {
		var faye = new Faye.Client(window.faye_url);
		faye.subscribe(window.faye_channel, function (data) {
			try {
				data.params = JSON.parse(data.text);

			} catch(e) {
				//console.log('json', e, data.text)
			}

			if (data._type == 'notification') {
				if (data.object_table != 'ConversationMessage') {
					show_notifications([data]);
				} else {
					if (window.activeConversationUser == data.params.user) {
						get_notifications({first:true});
					} else {
						get_notifications();
					}
				}
				$(window).trigger('faye_notify', [data]);
			} else if (data._type == 'conversation_message') {
				$(window).trigger('conversation_message', [data]);
			}
			else {
				// console.log(data);
			}
		});
	});
    }


//  $('.tabs').tabs();

	$('#feedback-create-form').ajaxify({
		success: function (resp) {
			if (resp.status == 'success') {
				alert(t('Ваш вопрос принят'));
				$('#feedback-create-form').find('.inputnew').val('');
			}
		}
	});

	$('.send-activation-email').ajaxify_link({
		success: function () {
			alert(t('Код активации отправлен'));
		}
	});

	$('.complaint').live('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var item = $(this);
		var id = item.data('id');
		var type = item.data('type');

		var block = $('<div class="complaint-block"></div>')
			.append('<h4>'+t('Отправить жалобу администрации площадки')+'</h4><p>'+t('Если вы считаете, что пользователь нарушает правила площадки, отправьте нам об этом сообщение. Если это нужно, добавьте комментарий с описанием подробностей.')+'</p>')
//			.css({'top': item.offset().top, 'right': '-485px', 'margin-right':'50%','left':'initial'})
			.css({'top': item.offset().top, 'left':item.offset().left})
			.appendTo('body').fadeIn(200);
		var form =$('<form method="POST" action="/misc/addComplaint" class="basic"><textarea name="text"></textarea><input type="submit" value="'+t('Отправить')+'" /><input type="button" class="basic" value="'+t('Отменить')+'" /></form>')
			.appendTo(block);
		var i_id = $('<input type="hidden" name="id" value="' + id + '">');
		var i_type = $('<input type="hidden" name="table" value="' + type + '">');
		form.append(i_type).append(i_id);
		form.submit(function (e) {
			e.preventDefault();
//			var url = form.attr('action');
//			var data = form.serialize();
			 $.ajax({
            	url: form.attr('action'),
            	dataType: 'json',
            	type: 'post',
            	data: form.serialize(),
            	success: function(data) {
					complaint_block_close();
					if (data.status == 'error') {alert(t('Произошла ошибка'))}
					else {
						alert(data.message);
					}
				}
			 });
		});
		form.find('input:button').click(function () {
			complaint_block_close();
		});
		var complaint_block_close = function () {
			block.fadeOut(200, function () {
				block.remove();
			});
		}
	});

	$('.b-user').live('mouseenter', function() {
		var b = $(this);
		var menu = b.find('.u-menu');
//		menu = menu.clone(true).appendTo('body');
		var top = 0; //b.children('a').height() //b.offset().top - $('#page').offset().top;
		var left = b.find('._name').offset().left - b.offset().left; //b.offset().left - $('#page').offset().left;
		var bWidth = b.width();
		menu
				.css({'top': top, 'left': left})
			.stop().fadeIn(150);
	});
	$('.b-user').live('mouseleave', function () {
		var b = $(this);
		var menu = b.find('.u-menu');
		menu.stop().fadeOut(150, function(){menu.css('opacity', '1')});
	});
	$('.b-user .startmessage').live('click', function (e) {
		e.preventDefault();
		$(this).parent().hide()
			.closest('.u-menu')
				.find('.b-add-message')
				.show()
					.find('form input[type="text"]')
					.focus();
	});
	$('body').on('submit_message_usermenu', function(e, o) {
		var form = $(o.target);
		var object_id = form.find(':input[name=user_id]').val();

		if (!form.find('[name=text]').val().match(/\S+/) ||
			form.is('.sending')
		) return;

		form.addClass('sending');

		$.ajax({
			url: form.attr('action'),
			type: 'post',
			dataType: 'json',
			data: form.serialize(),
			success: function(data) {
				if (data.status == 'success') {

					form.find('[name=text]').val('');
				} else {
					console.log(data.message);
				}
			},
			complete: function() {
				form.removeClass('sending');
			}
		});
	});

	$('.remind-password a.ajax').click(function (e) {
		e.preventDefault();
		if ($(this).parents('#login_form').length > 0) {
			var block = $('#remind_password_block');
			block.removeAttr('style').css('visibility', 'hidden').show();
			bt = $(this).offset().top + 12;
			bl = $(this).offset().left - $('#menu1').offset().left - (block.innerWidth() - $(this).width())/2;
			block.css({'top': bt, 'left': bl, 'right': 'auto'}).hide().css('visibility', 'visible').fadeIn(300);
			$('#menu1').css('z-index', '1100');
		} else {
		$('#remind_password_block').removeAttr('style').fadeIn(300, function () {
//		window.Helpers.to_close($('#remind_password_block'));
		});
		}
	});
	$('.close_remind_password').click(function (e) {
		e.preventDefault();
		$('#remind_password_block').hide();
	});

	$('#remind_password').ajaxify({
		success: function (resp) {
			if (resp.status == 'success') {
				alert(t('Письмо со ссылкой для восстановления пароля отправлено на ваш e-mail'));
			} else {
				alert(resp.message);
			}
		}
	});

	//функция для аплоада. по триггеру появляется gritter-всплывашка, говорящая нам, что права не имели мы
	//файлы типа данного этого загружать
	$('body').bind('triggerWrongFile',function(event,obj){
		var message = t('Файл ')+obj.files[0].name + t(' не был загружен. ') + obj.result.message;
		if (typeof $.gritter == 'undefined') {
			alert(message);
		} else {
			var id = $.gritter.add({
				title: t('Произошла ошибка'),
				text: message,
				// image: image,
				time: 3000
			});
		}
	});

	var forbidden = function (trigger) {
		var block = $('#modal_authorisation_form');
		var form = block.find('form');
		trigger = $(trigger);
		var action = trigger.data('forbiddenAction') || trigger.text();
        var link = trigger.attr('href');
		if (trigger.data('forbiddenAction') == false) action = false;
		if (block.length > 0) {
			var window_scrollTop = $(window).scrollTop();

			block.find('.msg').remove();
			if (action && action != '') {
				var str = t('Для того, чтобы ') + $.trim(action.toLowerCase()) + t(', вам нужно войти в систему или зарегистрироваться');
				$('<div class="msg"></div>').text(str).prependTo(block);
			}
            if (link) {
                block.data('link', link);
            }

			var top = trigger.offset().top + trigger.height();
			if (top + block.innerHeight() + 5 > window_scrollTop + $(window).height() || top + block.innerHeight() + 5 > $(document).height()) top = trigger.offset().top - block.innerHeight();
			if (top < window_scrollTop) top = trigger.offset().top + trigger.height();
			var left = trigger.offset().left - (block.innerWidth() - trigger.innerWidth()) / 2;
			if (left + block.innerWidth() > $(document).width()) left = $(document).width() - block.innerWidth() -5;
			if (left < 0) left = 5;

			block.css({
				'top': top,
				'left': left
			}).fadeIn(200);
		}
	}

	var trigger_forbidden_link = function(e) {
		e.preventDefault();
		forbidden(this);
	}

	$(document).on('click', 'a.forbidden, button.forbidden, input[type="submit"].forbidden', trigger_forbidden_link);

	$(document).on('click', '.modal .close-icon', function () {
		$(this).closest('.modal').fadeOut(200);
	});

	$(function () {
		$('#top_login_form').ajaxify({
			success: function (resp) {
				if (resp.status == 'success') {
                    location.href = resp.return_url;
				} else {
					alert(resp.message);
				}
			}
		});
	});

	$('#create_forum_topic').ajaxify({
		success: function (resp) {
            $('#forum-topic-template').template('forum_topic_template');
			if (resp.status == 'success') {
                var topic = resp.topic

                var t = $.tmpl('forum_topic_template', resp);

                $('ul.topics').prepend(t);
                var scroll_top = $('#page').offset().top - 5;
                $('html, body').animate({scrollTop: scroll_top}, 500);
                $('#create_forum_topic #name').val('');
                $('#create_forum_topic #comment').val('').text('');
			} else {
				alert(t('Произошла ошибка'));
			}
		}
	});

    //make liquid menu for forums

    function liquidMenu(){
        $.waypoints.settings.scrollThrottle = 30;

        $('.left.col').waypoint(function(event, direction) {

        }, {
            offset: '-100%'
        }).find('.mainmenu').waypoint(function(event, direction) {
            var leftcol = $(this).closest('.left.col');
            if (leftcol.height() <= $('#layout-content').height()) {
                $(this).parent().toggleClass('sticky', direction === "down");
            }
            event.stopPropagation();
        });
    };

    if ($('.mainmenu.forum-menu').length > 0){
        liquidMenu();
    }

    $('.not-activated-alert.social a.read-notification').click(function(e) {
        el = $(this);
        $.ajax({
            url: '/user/deactivateSocialNotification',
            success: function(r) {
                el.closest('.black-milk').hide();
            }

        });
    });

    $('.not-activated-alert.social a.mute-notification').click(function(e) {
        el = $(this);
        $.ajax({
            url: '/user/muteSocialNotification',
            success: function(r) {
                el.closest('.black-milk').hide();
            }

        })
    });

    $('.not-activated-alert.social a.basic.button, .not-activated-alert.social a.user').click(function(e) {
        e.preventDefault();
        el = $(this);
        $.ajax({
            url: '/user/deactivateSocialNotification',
            success: function(r) {
                // el.closest('.black-milk').hide();
                location.href = el.attr('href');
            }
        })
    });

	$('#menu1').on('mouseenter', '.main > ul > li', function(e) {
		var li = $(this);
		var s = li.find('ul');
		s.fadeIn(200);
	});
	$('#menu1').on('mouseleave', '.main > ul > li', function(e) {
		var li = $(this);
		var s = li.find('ul');
		s.hide();
	});
});
