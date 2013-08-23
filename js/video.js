///
;(function(){
	
// if (window.AGROTV && 1) {
		

	
	var o = window.AGROTV = { };
	
	o.video = function(id) {
		$(function() {
			var el = $('#'+id)
			
			var img = $('<img src="../img/splash.jpg">').click(function() {
            	el.addClass('opened').empty().append(o.code(id));
	        });
	
			el.append(img)
		});
	}	
	
	o.code = function(id) {	
														
		var player = $f(id,
			{
				src: "/flowplayer/flowplayer-3.2.7.swf",
				wmode: 'opaque'
			},
            {
                clip : {
                    scaling: 'orig',
                    provider: 'rtmpt',
                    url: $("#"+id).attr('data-url') || "livestream1",
                    ipadUrl: "http://video.agro-tv.ru:8082/hls/livestream1/index.m3u8"
             	},
	            plugins: {
                	controls: {
                    	volume: true,
                     	scrubber: false,
                     	time: false,
                     	opacity: 0.8,
                     	tooltips: {
                        	buttons: true,	
                        	mute: 'Выключить звук',
                        	unmute: 'Включить звук',
                        	play: 'Включить',
                        	pause: 'Приостановить',
                        	fullscreen: 'Посмотреть на полном экране'
                     	}
                 	},

                 rtmpt: {
                     url: 'flowplayer.rtmp-3.2.3.swf',
                     netConnectionUrl: 'rtmpt://video.agro-tv.ru/'
                 }
	        }
	    }).ipad({
			// url: "http://video.agro-tv.ru:8082/hls/livestream1/index.m3u8",
			// simulateiDevice: true
        });

			
	}
// }
})();