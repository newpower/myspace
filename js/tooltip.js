/*

Пример

без параметров
<input type="text" name="numberMask" data-tooltip='"Указывая номера пользователей"'>

с параметрами
<input type="text" name="numberMask" data-tooltip='{ "content": "Указывая номера пользователей", "offset": { "top": 30 }  }'>


$('[data-tooltip]')
	.tooltip({
		offset: {  left: 100 }
	})
	.tooltip('show')

покажет tooltip с отступом



*/


(function($) {
	var Tooltip = function() {
			this.init.apply(this, arguments);
		};

	Tooltip.defaults = {
		side: 'right',
		content: '',
		_class: '',
		offset: {
			top: 0,
			left: 0
		}
	}

	Tooltip.prototype = {
		constructor: Tooltip,

		init: function(el, options) {
			var self = this;
			this.options = $.extend(true, {}, Tooltip.defaults, options || {});
			
			// console.log('init tooltip', el, this.options, options) 

			this.el = el;

			this.el.focus(function() {
				self.show();
			}).blur(function() {
				self.hide();
			})
		},

		text: function(t) {
			if (!this.html) this.insert();
			this.html.html(t);
		},

		insert: function() {
			if (this.inserted) return;
			this.inserted = true;
			$('body').prepend(this.html = $('<div class="js-tooltip '+ this.options._class +' "></div>'));
			this.text(this.options.content);
			this.html.hide()
		},

		pos_timer: 0,
		pos: function() {
			if (!this.shown && this.pos_timer) {
				return clearInterval(this.pos_timer);
			}

			var self = this;

			var f = function(first) {
					var o = { left: 0, top: 0 };
					if (self.el && self.el.offset()) o = self.el.offset();
					
					if (self.options.side == 'right') {
						o.left += self.el.width() + 5;
					}

					if (self.options.side == 'inside') {
						o.left += 5;
						o.top += 5;
					}

					var oLeft = Math.round(o.left);
					var oTop = Math.round(o.top);

					if (oTop != parseInt(self.html.css('top')) || oLeft != parseInt(self.html.css('left'))){
						self.html.animate({
							left: oLeft + self.options.offset.left,
							top: oTop + self.options.offset.top
						}, first || 200);
					}





					if (!first && !self.shown) clearInterval(self.pos_timer)
				}

			this.pos_timer = setInterval(f, 1000);
			f(1);
		},
		

		shown: false,
		show: function() {
			if (this.shown) return;
			this.shown = true;
			this.insert();
			this.pos();

			var self = this;

			this.html.fadeIn(300, function() {
				self.html.css({ opacity: 1 })
			});

			console.log('show tooltip', this, this.el) 
		},

		hide: function() {
			if (!this.shown) return;
			this.shown = false;
			this.html.stop().fadeOut(300);
		}
	}


	$.fn.tooltip = function(option) {
		if (option == 'inst') return this.first().data('tooltip-inst');
		var arg = Array.prototype.slice.call(arguments, 1)

		return this.each(function() {
			var $this = $(this);

			var p = $this.data('tooltip-inst');

			if (p) {
				p[option] && p[option].apply(p, arg);
			} else {
				var params = {};
				var attr = $this.data('tooltip');
				if (typeof attr == 'object') params = $this.data('tooltip');
				if (typeof attr == 'string') params = { content: $this.data('tooltip') }
				if (typeof option == 'object') $.extend(params, option);

				$this.data('tooltip-inst', new Tooltip($this, params));
			}
		})
	}


	$.fn.tooltip.defaults = Tooltip.defaults;

})(window.jQuery);