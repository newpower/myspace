if(typeof console === "undefined") {
	console = {
		log: function() { },
		warn: function() { },
		error: function() { },
		info: function() { }
	};
} else{
	if (typeof console.log == "undefined"){
		console.log = function() {};
	};
	if (typeof console.info == "undefined"){
		console.info = function(){};
	};
	if (typeof console.warn == "undefined"){
		console.warn = function(){};
	};
	if (typeof console.error == "undefined"){
		console.error = function(){};
	};
}