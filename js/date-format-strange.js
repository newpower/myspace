// Simulates PHP's date function
Date.prototype.mformat = function(format) {
	var returnStr = '';
	var replace = Date.replaceChars;
	if (this.yesterday() && (format == 'd M' || format == 'd M Y')) return "вчера";
	if (this.today() && (format == 'd M' || format == 'd M Y')) return "сегодня";
	if (this.tomorrow() && (format == 'd M' || format == 'd M Y')) return "завтра";
	for (var i = 0; i < format.length; i++) {
		var curChar = format.charAt(i);
		if (replace[curChar]) {
			returnStr += replace[curChar].call(this);
		} else {
			returnStr += curChar;
		}
	}
	return returnStr;
};
Date.prototype.yesterday = function() {
	var d = new Date( (new Date()).valueOf() - 24 * 60 * 60 * 1000 );
	return (d.getDate() == this.getDate() && d.getMonth() == this.getMonth() && d.getYear() == this.getYear())
};
Date.prototype.tomorrow = function() {
	var d = new Date( (new Date()).valueOf() + 24 * 60 * 60 * 1000 );
	return (d.getDate() == this.getDate() && d.getMonth() == this.getMonth() && d.getYear() == this.getYear())
};
Date.prototype.today = function() {
	var d = new Date();
	return (d.getDate() == this.getDate() && d.getMonth() == this.getMonth() && d.getYear() == this.getYear())
};
Date.replaceChars = {
	shortMonths: ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'],
	longMonths: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
	shortDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	longDays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
	
	// Day
	d: function() { return (this.getDate() < 10 ? '0' : '') + this.getDate(); },
	D: function() { return Date.replaceChars.shortDays[this.getDay()]; },
	j: function() { return this.getDate(); },
	l: function() { return Date.replaceChars.longDays[this.getDay()]; },
	N: function() { return this.getDay() + 1; },
	S: function() { return (this.getDate() % 10 == 1 && this.getDate() != 11 ? 'st' : (this.getDate() % 10 == 2 && this.getDate() != 12 ? 'nd' : (this.getDate() % 10 == 3 && this.getDate() != 13 ? 'rd' : 'th'))); },
	w: function() { return this.getDay(); },
	z: function() { return "Not Yet Supported"; },
	// Week
	W: function() { return "Not Yet Supported"; },
	// Month
	F: function() { return Date.replaceChars.longMonths[this.getMonth()]; },
	m: function() { return (this.getMonth() < 9 ? '0' : '') + (this.getMonth() + 1); },
	M: function() { return Date.replaceChars.shortMonths[this.getMonth()]; },
	n: function() { return this.getMonth() + 1; },
	t: function() { return "Not Yet Supported"; },
	// Year
	L: function() { return "Not Yet Supported"; },
	o: function() { return "Not Supported"; },
	Y: function() { return this.getFullYear(); },
	C: function() {return ((new Date).getFullYear() == this.getFullYear() ? '' : this.getFullYear()); },
	y: function() { return ('' + this.getFullYear()).substr(2); },
	// Time
	a: function() { return this.getHours() < 12 ? 'am' : 'pm'; },
	A: function() { return this.getHours() < 12 ? 'AM' : 'PM'; },
	B: function() { return "Not Yet Supported"; },
	g: function() { return this.getHours() % 12 || 12; },
	G: function() { return this.getHours(); },
	h: function() { return ((this.getHours() % 12 || 12) < 10 ? '0' : '') + (this.getHours() % 12 || 12); },
	H: function() { return (this.getHours() < 10 ? '0' : '') + this.getHours(); },
	i: function() { return (this.getMinutes() < 10 ? '0' : '') + this.getMinutes(); },
	s: function() { return (this.getSeconds() < 10 ? '0' : '') + this.getSeconds(); },
	// Timezone
	e: function() { return "Not Yet Supported"; },
	I: function() { return "Not Supported"; },
	O: function() { return (this.getTimezoneOffset() < 0 ? '-' : '+') + (this.getTimezoneOffset() / 60 < 10 ? '0' : '') + (this.getTimezoneOffset() / 60) + '00'; },
	T: function() { return "Not Yet Supported"; },
	Z: function() { return this.getTimezoneOffset() * 60; },
	// Full Date/Time
	c: function() { return "Not Yet Supported"; },
	r: function() { return this.toString(); },
	U: function() { return this.getTime() / 1000; }
};




function parseDate(date) {
	if (date instanceof Date) {
		return date
	}
	
	var nullmformat = {
		mformat:function() {
			return '-'
		}
	}
	try {
		if (date == null) return nullmformat;
		var found = false;
		var d_;
		var d = date.split(',');
		if (d.length == 6) {
			found = true;
		}
		if (!found && date.match(/(\d+)\.(\d+)\.(\d+)/)) {
			d_ = date.match(/(\d+)\.(\d+)\.(\d+)/);
			d_.shift();
			if (d_.length == 3) {
				d = d_.reverse();
				found = true;
			}
		}
		if (!found && date.match(/(\d{4})-(\d+)-(\d+)\s(\d+):(\d+):(\d+)/)) {
			d_ = date.match(/(\d{4})-(\d+)-(\d+)\s(\d+):(\d+):(\d+)/);
			d_.shift();
			if (d_.length == 6) {
				d = d_;
				found = true;
			}
		}
		if (!found && date.match(/(\d{4})-(\d+)-(\d+)/)) {
			d_ = date.match(/(\d{4})-(\d+)-(\d+)/);
			d_.shift();
			if (d_.length == 3) {
				d = d_;
				found = true;
			}
		}

		
		if (!found) {
			return nullmformat;
		}
		if (d.length < 6){
			d.push(0);
			d.push(0);
			d.push(0);
		}
		return new Date(d[0],d[1]-1,d[2],d[3],d[4],d[5]);
	} 
	catch (e) {
		return nullmformat
	}
}

function shortDate(date) {
	return parseDate(date).mformat('d M');
}
function shortDateWithCYear(date) {
	return parseDate(date).mformat('d M C');
}
function shortDateTime(date) {
	return parseDate(date).mformat('d M, H:i');
}

function actualDate(date) {

	var current_data = new Date();
	var format = '';
	if (parseDate(date).mformat('Y') == parseDate(current_data).mformat('Y') &&
		parseDate(date).mformat('d') == parseDate(current_data).mformat('d') &&
		parseDate(date).mformat('m') == parseDate(current_data).mformat('m')) {

		format = 'H:i';

	} else if (parseDate(date).mformat('Y') == parseDate(current_data).mformat('Y')){
		format = 'd F';
	} else {
		format = 'd F Y';
	}

	return parseDate(date).mformat(format);
}

function shortDateWithYear(date) {
	return parseDate(date).mformat('d M Y');
}

function inputDate(date) {
	return parseDate(date).mformat('d.m.Y');
}