(function () {

    var $ = jQuery;

    window.NumberMask = {
        defaults:{
            russian_phone: { mask:'+9 (999) 999-99-99', autoTab:false },
            world_phone: { mask:'+9 999 999 99 99 99', autoTab:false },
            short_phone: { mask:'p9999', autoTab:false },

            world:true,
            aster:false,

            // type: 'tel'

            //short: false,
            free_input: false,

            default_code:'7'
        },

        init:function () {
            if (this.inited) return;
            this.inited = true;

            if (!$) throw new Error('number_mak needs "jQuery"');
            if (!$.fn.setMask) throw new Error('number_mak needs "jQuery.Meio.Mask"');

            $.mask.fixedChars = '[(),.:/ -/]';
            $.mask.fixedCharsRegG = new RegExp($.mask.fixedChars, 'g');
            $.mask.rules['n'] = /[0-9\*]/;
            $.mask.rules['p'] = /[0-9\+]/;
            $.mask.rules['f'] =  /[1-9]/;
            $.mask.options.autoTab = false;

            $.fn.unmaskedVal = function() {
                var el = this[0];
                var nm = $(el).data('number_mask');
                return nm ? $(el).val().replace(/\D/g, '') : $(el).val().replace($.mask.fixedCharsRegG, '');
            }
        },

        cursor:function (el, l) {
            var input = $(el)[0];

            setTimeout(function () {
                if (typeof l == 'undefined') l = $(el).val().length;

                if (input.setSelectionRange) {
                    input.focus();
                    input.setSelectionRange(l, l);
                } else if (input.createTextRange) {
                    var range = input.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', l);
                    range.moveStart('character', l);
                    range.select();
                }
            }, 1);
        },

        format: function(v, options) {
            options = $.extend(true, { }, this.defaults, options || { });

            if (!options.free_input) {
                if (v.match(/^\d{10}$/)) v = '7' + v;
                if (v.match(/^\d{11,}$/)) v = '+' + v;
            }

            var mask = this.choose(v, options).mask;
            return  mask ? $.mask.string(v, mask) : v;
        },

        choose: function(val, options) {
            var p = { mask: '' , val: '' };
            options = options || this.defaults;

            if (val == '') {
                if (options.free_input) {
                    //do nothing
                    p.mask = ''
                } else if (options.short) {
                    p.mask = options.short_phone.mask
                } else {
                    p.val = '+'
                }
            }

            if (val.indexOf('+') == 0) {
                if (options.world) {
                    p.mask = options.world_phone.mask
                } else {
                    p.mask = options.russian_phone.mask
                }
            }

            if (val.indexOf('+'+options.default_code) == 0) {
                p.mask = options.russian_phone.mask
            }

//            console.log("choose", arguments, p);
            return p;
        },

        apply: function(el, mask) {
            var d = el.data('number_mask') || {};

            if (mask && mask != d.current) {
                el.setMask({ mask: mask, autoTab: false });
                el.toggleClass('long',  d.world_phone && mask == d.world_phone.mask);
                d.current = mask;
            }

            return el;
        },

        set: function (el, options) {
            this.init();
            var that = this;

            options = $.extend(true, { }, this.defaults, options || {});

            if (options.aster) {
                options.russian_phone.mask = options.russian_phone.mask.replace(/9/g, 'n');
                options.world_phone.mask = options.world_phone.mask.replace(/9/g, 'n');
            }

            el = $(el);
            if (options.type && !$.browser.msie)  el[0].type = options.type;

            var v = el.val()

            if (v != '') {
                v = this.format(v, options);
                el.val(v);
            }

            this.apply(el, this.choose(v).mask || options.russian_phone.mask)

                .focus(function () {
                    if (!el.val()) {
                        el.val('+' + options.default_code);
                        that.cursor(el);
                        that.apply(el, that.choose(el.val(), options).mask);
                    }

                })

                .blur(function () {
                    if (el.val() == '+' || el.val() == '+' + options.default_code) {
                        el.val('');
                    }
                })

                .keyup(function (e) {
                    setTimeout(function () {
                        var p = that.choose(el.val(), options)

                        if (p.mask) {
                            that.apply(el,p.mask);
                        } else {
                            el.data('number_mask').current = 0;
                            el.unsetMask()
                        }

                        if (p.val) {
                            el.val(p.val);
//                            el.keyup();
                        }

                        if (options.aster) {
                            var p;
                            if ((p = el.val().indexOf('*')) > -1) {
                                el.attr('maxlength', p);
                            } else if (el.attr('maxlength')) {
                                el.removeAttr('maxlength')
                            }
                        }
                    }, 1);

                }).data('number_mask', options)
        }
    };

})();
