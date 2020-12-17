$(document).ready(function(){
	function InitFancyPrivacy(){
		$('.privacy')
			.attr('href', 'http://synergy.ru/lp/_chunk/privacy.php')
			.fancybox({
			maxWidth  : 800,
			autoResize: true
		});
	}
	if(!$.fn.fancybox){
		var script = document.createElement('script');
		script.src = "http://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js";
		document.body.appendChild(script);
		script.onload = function() {
			if (!this.executed) { // выполнится только один раз
				this.executed = true;
				InitFancyPrivacy();
			}
		};
		script.onreadystatechange = function() {
			var self = this;
			if (this.readyState == "complete" || this.readyState == "loaded") {
				setTimeout(function() {
					self.onload()
				}, 0); // сохранить "this" для onload
			}
		};
		$('head').append('<link href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet" type="text/css">');
	}else{
		InitFancyPrivacy();
	}
});