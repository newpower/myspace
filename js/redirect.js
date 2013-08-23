$(document).ready(function(){
	var vars = [], hash , url;
    	
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

	for(var i = 0; i < hashes.length; i++)
	{
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}

	url = "/" + window.location.pathname.split('/')[1] + "/search#json=1&type=1&model[division_id]=" + vars['division_id'] + "&division_id=" + vars['division_id'] + "&model[general][region][]=" + vars['region_id'];
	window.location.href = url;
});