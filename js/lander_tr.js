/*  lander.js 2.4 | 2016-10-06  */
var LanderJS = (function() {

	/* Статические объекты */
	var
	LANDER = {},
	TRANSLATE = {
		ru: {sending: 'Отправка...'},
		en: {sending: 'Sending...'},
		kz: {sending: 'Жіберу...'},
		cn: {sending: '发送'},
		es: {sending: 'Envío...'}
	},
	GLOBAL_LANG
	;

	/* Проверка наличия jQuery на странице */
	LANDER.check = function() {
		if (typeof jQuery == 'undefined') {
			LANDER.loadJS( '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', LANDER.check );
			return;
		}

		LANDER.init();
	};

	/* Инициализация */
	LANDER.init = function() {
		$(document).ready(function(){
			LANDER.run();
		});
	}

	/* Запуск хелперов */
	LANDER.run = function() {
		GLOBAL_LANG = $('html').attr('lang') || 'ru';

		LANDER.initEntranceNCall();	/* кнопки внизу Поступить и Позвонить #171854 */
		LANDER.placeholder();       /* Плейсхолдер */
		LANDER.data_cost();         /* Подстановка стоимости */
		LANDER.form();              /* Общие обработчики форм */
		LANDER.inputMasks();        /* Маска телефона */
		LANDER.formValidation();    /* Валидация основных форм */
		LANDER.grid();              /* Сетка grid */
		LANDER.devCookie();			/* хоткей для dev */
		LANDER.clearCNDcache();		/* хоткей очистить кэщ CDN */
		LANDER.privacy();           /* Пользовательское соглашение */
		LANDER.outlineagency();		/* Интеграция Outlineagency */
		LANDER.checkRegion();		/* Определение региона пользователя по IP */
		LANDER.init_md5();			/* включаем md5 функцию */
		//LANDER.initAutoSubmit();	/* отправка формы без ведома пользователя по блюру #175347 */

	};



	/* Проверка загрузки Лендера */
	LANDER.loaded = function() {
		if(console) console.log('LanderJS-Loaded');
		return true;
	};

	/* Плейсхолдеры для IE 9 и ниже */
	LANDER.placeholder = function(){
		(function(b){function d(a){this.input=a;a.attr("type")=="password"&&this.handlePassword();b(a[0].form).submit(function(){if(a.hasClass("placeholder")&&a[0].value==a.attr("placeholder"))a[0].value=""})}d.prototype={show:function(a){if(this.input[0].value===""||a&&this.valueIsPlaceholder()){if(this.isPassword)try{this.input[0].setAttribute("type","text")}catch(b){this.input.before(this.fakePassword.show()).hide()}this.input.addClass("placeholder");this.input[0].value=this.input.attr("placeholder")}},hide:function(){if(this.valueIsPlaceholder()&&this.input.hasClass("placeholder")&&(this.input.removeClass("placeholder"),this.input[0].value="",this.isPassword)){try{this.input[0].setAttribute("type","password")}catch(a){}this.input.show();this.input[0].focus()}},valueIsPlaceholder:function(){return this.input[0].value==this.input.attr("placeholder")},handlePassword:function(){var a=this.input;a.attr("realType","password");this.isPassword=!0;if((/msie/i).test(navigator.userAgent)&&a[0].outerHTML){var c=b(a[0].outerHTML.replace(/type=(['"])?password\1/gi,"type=$1text$1"));this.fakePassword=c.val(a.attr("placeholder")).addClass("placeholder").focus(function(){a.trigger("focus");b(this).hide()});b(a[0].form).submit(function(){c.remove();a.show()})}}};var e=!!("placeholder"in document.createElement("input"));b.fn.placeholder=function(){return e?this:this.each(function(){var a=b(this),c=new d(a);c.show(!0);a.focus(function(){c.hide()});a.blur(function(){c.show(!1)});(/msie/i).test(navigator.userAgent)&&(b(window).load(function(){a.val()&&a.removeClass("placeholder");c.show(!0)}),a.focus(function(){if(this.value==""){var a=this.createTextRange();a.collapse(!0);a.moveStart("character",0);a.select()}}))})}})(jQuery);

		$('input[placeholder], textarea[placeholder]').placeholder();
	};

	LANDER.initEntranceNCall = function(){

		if($('.lander-widget-bottom-buttons').length) return;

		if(/synergy.ru|synergyonline.ru|synergy.mba/i.test(window.location.hostname)){

			$('body').append('<style>#call-button,#entrance-mobile{display: none !important;}</style>');

			if(/dev./i.test(window.location.hostname)){
				return;
			}

			$('body').append('<style>@font-face{font-family:"Lander-ProximaNova";src:url("http://synergy.ru/lp/_chunk/fonts/proximanova-reg-webfont.eot");src:url("http://synergy.ru/lp/_chunk/fonts/proximanova-reg-webfont.eot?#iefix") format("embedded-opentype"),url("http://synergy.ru/lp/_chunk/fonts/proximanova-reg-webfont.woff2") format("woff2"),url("http://synergy.ru/lp/_chunk/fonts/proximanova-reg-webfont.woff") format("woff"),url("http://synergy.ru/lp/_chunk/fonts/proximanova-reg-webfont.ttf") format("truetype"),url("http://synergy.ru/lp/_chunk/fonts/proximanova-reg-webfont.svg#proxima_nova_rgregular") format("svg");font-weight:400;font-style:normal}[class*="lander-"],[class*="lander-"] *{box-sizing:border-box;font-family:"Lander-ProximaNova"}.lander-widget-bottom-buttons{display:none;position:fixed;bottom:0;left:0;right:0;width:100%;font-size:7vmin;font-weight:600;text-align:center;line-height:12vmin;text-transform:uppercase;z-index:5000;cursor:pointer}.lander-widget-bottom-buttons__entrance{display:block;float:left;width:50%;padding:2% 0;background-color:#80c1bb;color:#fff}.lander-widget-bottom-buttons__phone{background-size:15%;display:block;float:right;width:50%;padding:2% 0;background-position:center;background-repeat:no-repeat;background-color:#ECECF7;text-decoration:none !important}.lander-widget-entrance-popup{overflow-y:auto;display:none;position:fixed;left:0;right:0;width:100%;top:0;bottom:0;background-color:#fff;z-index:5000;padding:5%}.lander-widget-entrance-popup__back{color:#80c1bb;font-size:7vmin}.lander-widget-entrance-popup__form{margin-top:10%}.lander-widget-entrance-popup__title{font-size:7vmin;text-align:center;text-transform:uppercase}.lander-widget-entrance-popup__input{display:block;width:100%;background-color:#ebebeb;margin-top:5%;font-size:7vmin;border:1px solid #777;padding:5%}.lander-widget-entrance-popup__submit{display:block;width:100%;padding:4%;text-transform:uppercase;font-size:9vmin;color:#fff;background-color:#80c1bb;border:none;margin-top:5%;transition:all 0.3s ease}.lander-widget-entrance-popup__submit[disabled]{background-color:#d6d6d6}@media (min-width:641px){.lander-widget-bottom-buttons{display:none !important}.lander-widget-entrance-popup{display:none !important}}</style>');

			var that = {

				/**
				 * Получить массив из всех телефонов на странице
				 * @return {string[]} [description]
				 */
				getPhones(){

					var $phones = $('a[href*="tel:"]');
					var phones = [];

					$phones.each(function(){

						var currentPhone = $(this).attr('href').replace(/[^0-9+]/gi, '');

						if( phones.indexOf(currentPhone) == -1 ){

							phones.push(currentPhone);

						}

					});

					return phones;

				},
				widgets: {

					bottomButtons: '\
					<div class="lander-widget-bottom-buttons">\
						<div class="lander-widget-bottom-buttons__entrance"></div>\
						<a href="#" class="lander-widget-bottom-buttons__phone" style="background-image: url(//synergy.ru/lander/alm/js/img/phone.svg)">&nbsp;</a>\
					</div>\
					',
					entrancePopup: '\
						<div class="lander-widget-entrance-popup">\
							<a href="#" class="lander-widget-entrance-popup__back"></a>\
							<form action="" class="lander-widget-entrance-popup__form">\
								<p class="lander-widget-entrance-popup__title"></p>\
								<input type="text" name="name" class="lander-widget-entrance-popup__input" />\
								<input type="text" name="phone" class="lander-widget-entrance-popup__input" />\
								<input type="text" name="email" class="lander-widget-entrance-popup__input" />\
								<button class="lander-widget-entrance-popup__submit"></button>\
							</form>\
						</div>\
					'

				},
				translate: {

					ru: {
						widgetEntrancePopupTitle: 'Подобрать программу и&nbsp;поступить',
						widgetEntrancePopupBack: '	&#8592; Вернуться',
						widgetEntrancePopupSubmit: 'Отправить',
						widgetBottomButtonsEntrance: 'Поступить'
					},
					en: {
						widgetEntrancePopupTitle: 'Choose a&nbsp;programe and apply',
						widgetEntrancePopupBack: '	&#8592; Back',
						widgetEntrancePopupSubmit: 'Send',
						widgetBottomButtonsEntrance: 'Apply'
					}

				}

			};

			that.currentLanguage = that.translate[GLOBAL_LANG];

			var phone = 'tel:' + (that.getPhones()[0] || '88001000011');

			var $widgetButtons = $(that.widgets.bottomButtons);
			$('.lander-widget-bottom-buttons__entrance', $widgetButtons).html(that.currentLanguage.widgetBottomButtonsEntrance);
			$('.lander-widget-bottom-buttons__phone', $widgetButtons)
				.attr('href', phone)
				.css('background-image', );

			var $widgetPopup = $(that.widgets.entrancePopup);
			$('.lander-widget-entrance-popup__title', $widgetPopup).html(that.currentLanguage.widgetEntrancePopupTitle);
			$('.lander-widget-entrance-popup__submit', $widgetPopup).html(that.currentLanguage.widgetEntrancePopupSubmit);
			$('.lander-widget-entrance-popup__back', $widgetPopup).html(that.currentLanguage.widgetEntrancePopupBack);

			var landAction = $('form:not(.nolander)').first().attr('action');

			$('.lander-widget-entrance-popup__form', $widgetPopup).attr('action', landAction);

			$('body').append($widgetButtons, $widgetPopup);
			//that.initForms($widgetPopup);

			var widgetHeight = $widgetButtons.height();
			var windowHeight = $(window).height();

			$(document).on('click', '.lander-widget-bottom-buttons__entrance', function(ev){

				$( 'input[name="name"]', $(ev.currentTarget) ).trigger('focus');
				$widgetPopup.fadeIn();

			});

			$('a.lander-widget-entrance-popup__back').on('click', function(ev){

				$widgetPopup.fadeOut();
				return false; 

			});

			$(document).on('focus change input', 'form', function(ev){

				/*if(($widgetButtons).css('display') == 'block') */$widgetButtons.stop().fadeOut();

			});

			$(document).on('focusout', 'form', function(ev){

				if($widgetButtons.data('lander-widget-buttons-init-scrollactive')){

					/*if(($widgetButtons).css('display') == 'none') */$widgetButtons.stop().fadeIn();

				}

			});

			$(window).on('lander:widget-buttons-init scroll', function(ev){

				var documentHeight = $(document).height();

				if( // скрываем снизу
					documentHeight - (window.scrollY + windowHeight + widgetHeight) < 100 || 
					// скрываем сверху
					window.scrollY + widgetHeight < 100){

					$widgetButtons.fadeOut();
					$widgetButtons.data('lander-widget-buttons-init-scrollactive', false);

				} else {

					$widgetButtons.fadeIn();
					$widgetButtons.data('lander-widget-buttons-init-scrollactive', true);

				}

			}).trigger('lander:widget-buttons-init');

		}

	}

	/* Определение региона пользователя по IP */
	LANDER.checkRegion = function() {
		$.getJSON('https://syn.su/tools/getRegions.php', {'lang': 'en', 'fields': 'country,city,lat,lon,status,message'}, function(data){
			if ($( 'input[name="phone"]:not(.intlTelInput)' ).val() == '') {
				if (data.country == 'Russia') {
					$( "input[name='phone']:not(.intlTelInput)" ).val('7');
				}
				else if (data.country == 'United States') {
					$( "input[name='phone']:not(.intlTelInput)" ).val('1');
				}
			}
		});
	};

	/* Парсер location URL по параметру */
	LANDER.getQuery = function(query) {
		query = query.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var
		expr = "[\\?&]" + query + "=([^&#]*)",
		regex = new RegExp(expr),
		results = regex.exec(window.location.href)
		;
		if (results !== null) {
			return results[1];
		} else {
			return false;
		}
	};

	/* Возвращает массив из URI */
	LANDER.URLToArray = function(url) {
		var
		request = {},
		pairs = url.substring(url.indexOf('?') + 1).split('&')
		;
		for (var i = 0; i < pairs.length; i++) {
			if(!pairs[i])
				continue;
			var pair = pairs[i].split('=');
			request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
		}
		return request;
	};

	/* Функция кодирования кириллицы в action форм для IE */
	LANDER.encodeFormAction = function($form) {
		/* Кодирование делаем только для IE <= 11 */
		if ( !(navigator.userAgent.indexOf('MSIE')!==-1 || navigator.appVersion.indexOf('Trident/') > 0) ) return;

		try{
			var
			goodaction = '',
			clearquery = $form.attr('action').split('?'),
			superquery = clearquery[1],
			splitter = superquery.split('&')
			;

			splitter.forEach(function(entry) {
				var keys = entry.split('=');
				if (!keys[0]) return;
				if (keys[0] !== 'r') {keys[1] = encodeURIComponent(keys[1]);}
				goodaction = goodaction+keys[0]+'='+keys[1]+'&';
			});
			$form.attr('action', clearquery[0]+'?'+goodaction);
		}catch(e){}
	};

	/* Парсер Cookie */
	LANDER.get_cookie = function(cookie_name) {
		var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
		if ( results )
			return ( decodeURIComponent( results[2] ) );
		else
			return null;
	};

	LANDER.set_cookie = function(name, value, options) {
	  options = options || {};

	  var expires = options.expires;

	  if (typeof expires == "number" && expires) {
	    var d = new Date();
	    d.setTime(d.getTime() + expires * 1000);
	    expires = options.expires = d;
	  }
	  if (expires && expires.toUTCString) {
	    options.expires = expires.toUTCString();
	  }

	  value = encodeURIComponent(value);

	  var updatedCookie = name + "=" + value;

	  for (var propName in options) {
	    updatedCookie += "; " + propName;
	    var propValue = options[propName];
	    if (propValue !== true) {
	      updatedCookie += "=" + propValue;
	    }
	  }

	  document.cookie = updatedCookie;
	}

	/* Парсер cookie системы аналитики piwik */
	LANDER.get_piwik_cookie = function(cookie_name) {
		var results = document.cookie.match ( '(^|;) ?' + cookie_name + '([^=;]*)=([^;]*)(;|$)' );
		if ( results ) {
			return ( decodeURIComponent( results[3] ) );
		}
		else
			return null;
	};


	/* Сохранение partner в куки для synergyregions */
	if ((window.location.hostname.indexOf('synergyregions.ru')  != -1)  && LANDER.getQuery('partner') !== false) {
		var D = new Date();
		D.setFullYear(D.getFullYear() + 3);
		document.cookie = 'SynergyPartner=' + LANDER.getQuery('partner') + ';expires=' + D.toGMTString() + ';path=/';

	}

	/* Сохранение partner в куки для synergyglobal */
	if ((window.location.hostname.indexOf('synergyglobal.ru')  != -1)  && LANDER.getQuery('partner') !== false) {
		document.cookie = 'GlobalPartner=' + LANDER.getQuery('partner') + ';path=/';
	}

	/* Сохранение utm-меток в куки для synergy и synergyonline */
	if (((window.location.hostname.indexOf('synergy.ru')  != -1) || (window.location.hostname.indexOf('synergyonline.ru')  != -1)  || (window.location.hostname.indexOf('synergy.mba')  != -1) || (window.location.hostname.indexOf('sbs.edu.ru')  != -1) || (window.location.hostname.indexOf('mosap.ru')  != -1) || (window.location.hostname.indexOf('universitetsadovodov.ru')  != -1))) {
		if (window.location.search.indexOf('utm_')  != -1) {
			var utmArr = ['utm_source','utm_medium','utm_campaign','utm_content','utm_term'];
			var currUtm = '';
			for (var i = 0, len = utmArr.length; i < len; i++) {
				currUtm = LANDER.getQuery(utmArr[i]);
				if (currUtm !== false && currUtm != '' && LANDER.get_cookie(utmArr[i]) == null ) {
					document.cookie =  utmArr[i] + '=' + currUtm + ';path=/';
				}
			}
		}
	}



	var
	PAPVisitorId  = LANDER.get_cookie('PAPVisitorId'),
	roistat_visit = LANDER.get_cookie('roistat_visit'),
	piwik_id	  = LANDER.get_piwik_cookie('_pk_id'),
	analytics_id  = LANDER.get_cookie('_ga'),
	/*PHPSESSID  = LANDER.get_cookie('PHPSESSID'),*/
	dataLayer     = window.dataLayer || []
	/*dataLayerTest = window.dataLayer || []*/
	;

	if(console) console.log(piwik_id);

	/* Подстановка стоимости из атрибута "data-cost" тега radio */
	LANDER.data_cost = function() {
		/*$('[name=radio]').change(function () {
			$('form').attr('data-cost', $('input[type=radio]:checked').attr('data-cost'));
		});*/
		$('[name=radio]').change(function () {
			var $currentForm = $(this).closest('form');
			$currentForm.attr('data-cost', $(this).attr('data-cost'));
		});
		$('[name=radio]').each(function(){
			var $currentForm = $(this).closest('form');
			$currentForm.attr('data-cost', $currentForm.find('input[type=radio]:checked').attr('data-cost'));
		});
	};

	LANDER.init_md5 = function(string){

		!function(n){"use strict";function t(n,t){var r=(65535&n)+(65535&t),e=(n>>16)+(t>>16)+(r>>16);return e<<16|65535&r}function r(n,t){return n<<t|n>>>32-t}function e(n,e,o,u,c,f){return t(r(t(t(e,n),t(u,f)),c),o)}function o(n,t,r,o,u,c,f){return e(t&r|~t&o,n,t,u,c,f)}function u(n,t,r,o,u,c,f){return e(t&o|r&~o,n,t,u,c,f)}function c(n,t,r,o,u,c,f){return e(t^r^o,n,t,u,c,f)}function f(n,t,r,o,u,c,f){return e(r^(t|~o),n,t,u,c,f)}function i(n,r){n[r>>5]|=128<<r%32,n[(r+64>>>9<<4)+14]=r;var e,i,a,h,d,l=1732584193,g=-271733879,v=-1732584194,m=271733878;for(e=0;e<n.length;e+=16)i=l,a=g,h=v,d=m,l=o(l,g,v,m,n[e],7,-680876936),m=o(m,l,g,v,n[e+1],12,-389564586),v=o(v,m,l,g,n[e+2],17,606105819),g=o(g,v,m,l,n[e+3],22,-1044525330),l=o(l,g,v,m,n[e+4],7,-176418897),m=o(m,l,g,v,n[e+5],12,1200080426),v=o(v,m,l,g,n[e+6],17,-1473231341),g=o(g,v,m,l,n[e+7],22,-45705983),l=o(l,g,v,m,n[e+8],7,1770035416),m=o(m,l,g,v,n[e+9],12,-1958414417),v=o(v,m,l,g,n[e+10],17,-42063),g=o(g,v,m,l,n[e+11],22,-1990404162),l=o(l,g,v,m,n[e+12],7,1804603682),m=o(m,l,g,v,n[e+13],12,-40341101),v=o(v,m,l,g,n[e+14],17,-1502002290),g=o(g,v,m,l,n[e+15],22,1236535329),l=u(l,g,v,m,n[e+1],5,-165796510),m=u(m,l,g,v,n[e+6],9,-1069501632),v=u(v,m,l,g,n[e+11],14,643717713),g=u(g,v,m,l,n[e],20,-373897302),l=u(l,g,v,m,n[e+5],5,-701558691),m=u(m,l,g,v,n[e+10],9,38016083),v=u(v,m,l,g,n[e+15],14,-660478335),g=u(g,v,m,l,n[e+4],20,-405537848),l=u(l,g,v,m,n[e+9],5,568446438),m=u(m,l,g,v,n[e+14],9,-1019803690),v=u(v,m,l,g,n[e+3],14,-187363961),g=u(g,v,m,l,n[e+8],20,1163531501),l=u(l,g,v,m,n[e+13],5,-1444681467),m=u(m,l,g,v,n[e+2],9,-51403784),v=u(v,m,l,g,n[e+7],14,1735328473),g=u(g,v,m,l,n[e+12],20,-1926607734),l=c(l,g,v,m,n[e+5],4,-378558),m=c(m,l,g,v,n[e+8],11,-2022574463),v=c(v,m,l,g,n[e+11],16,1839030562),g=c(g,v,m,l,n[e+14],23,-35309556),l=c(l,g,v,m,n[e+1],4,-1530992060),m=c(m,l,g,v,n[e+4],11,1272893353),v=c(v,m,l,g,n[e+7],16,-155497632),g=c(g,v,m,l,n[e+10],23,-1094730640),l=c(l,g,v,m,n[e+13],4,681279174),m=c(m,l,g,v,n[e],11,-358537222),v=c(v,m,l,g,n[e+3],16,-722521979),g=c(g,v,m,l,n[e+6],23,76029189),l=c(l,g,v,m,n[e+9],4,-640364487),m=c(m,l,g,v,n[e+12],11,-421815835),v=c(v,m,l,g,n[e+15],16,530742520),g=c(g,v,m,l,n[e+2],23,-995338651),l=f(l,g,v,m,n[e],6,-198630844),m=f(m,l,g,v,n[e+7],10,1126891415),v=f(v,m,l,g,n[e+14],15,-1416354905),g=f(g,v,m,l,n[e+5],21,-57434055),l=f(l,g,v,m,n[e+12],6,1700485571),m=f(m,l,g,v,n[e+3],10,-1894986606),v=f(v,m,l,g,n[e+10],15,-1051523),g=f(g,v,m,l,n[e+1],21,-2054922799),l=f(l,g,v,m,n[e+8],6,1873313359),m=f(m,l,g,v,n[e+15],10,-30611744),v=f(v,m,l,g,n[e+6],15,-1560198380),g=f(g,v,m,l,n[e+13],21,1309151649),l=f(l,g,v,m,n[e+4],6,-145523070),m=f(m,l,g,v,n[e+11],10,-1120210379),v=f(v,m,l,g,n[e+2],15,718787259),g=f(g,v,m,l,n[e+9],21,-343485551),l=t(l,i),g=t(g,a),v=t(v,h),m=t(m,d);return[l,g,v,m]}function a(n){var t,r="",e=32*n.length;for(t=0;t<e;t+=8)r+=String.fromCharCode(n[t>>5]>>>t%32&255);return r}function h(n){var t,r=[];for(r[(n.length>>2)-1]=void 0,t=0;t<r.length;t+=1)r[t]=0;var e=8*n.length;for(t=0;t<e;t+=8)r[t>>5]|=(255&n.charCodeAt(t/8))<<t%32;return r}function d(n){return a(i(h(n),8*n.length))}function l(n,t){var r,e,o=h(n),u=[],c=[];for(u[15]=c[15]=void 0,o.length>16&&(o=i(o,8*n.length)),r=0;r<16;r+=1)u[r]=909522486^o[r],c[r]=1549556828^o[r];return e=i(u.concat(h(t)),512+8*t.length),a(i(c.concat(e),640))}function g(n){var t,r,e="0123456789abcdef",o="";for(r=0;r<n.length;r+=1)t=n.charCodeAt(r),o+=e.charAt(t>>>4&15)+e.charAt(15&t);return o}function v(n){return unescape(encodeURIComponent(n))}function m(n){return d(v(n))}function p(n){return g(m(n))}function s(n,t){return l(v(n),v(t))}function C(n,t){return g(s(n,t))}function A(n,t,r){return t?r?s(t,n):C(t,n):r?m(n):p(n)}"function"==typeof define&&define.amd?define(function(){return A}):"object"==typeof module&&module.exports?module.exports=A:n.md5=A}(this);

	};

	/* Общие обработчики форм */
	LANDER.form = function() {
		$('form:not(.nolander)').on('submit', function () {
			/* Добавление скрытых полей с системной информацией */
			var
			$form = $(this),
			params = LANDER.URLToArray($form.attr('action')) || []
			;

			/* Обновление data-атрибутов из GET-параметров action формы */
			for (var item in params) {
				$form.data(item, params[item]);
			}

			/* Генерация уникального ID для транзакций (отправки форм) для систем электронной коммерции */
			var
			ID = function () {
				return 'id_' + Math.random().toString(36).substr(2, 9);
			},
			guid      = ID(),
			unit      = $form.data('unit'),
			type      = $form.data('type'),
			land      = $form.data('land'),
			version   = $form.data('version'),
			partner   = LANDER.getQuery('partner'),
			form      = $form.data('form'),
			cost      = $form.data('cost'),
			landname  = $form.data('landname'),
			speaker   = $form.data('speaker'),
			program   = $form.data('program'),
			dater     = $form.data('dater'),
			lang      = $form.data('lang'),
			link      = $form.data('link'),
			name      = $form.find('[name=name]').val(),
			phone     = $form.find('[name=phone]').val(),
			email     = $form.find('[name=email]').val(),
			refer     = document.referrer,
			bitrix	  = LANDER.getQuery('bitrix'),
			onlinepay = $form.data('cost'),
			mergelead = $form.data('cost')
			;


			/* Для sbs Partner в куки - приоритетнее, чем get-параметре */
			if (window.location.hostname == 'sbs.edu.ru') {
				if (LANDER.get_cookie('SynergyPartner') !== undefined || LANDER.get_cookie('SynergyPartner') !== null) {
					partner = LANDER.get_cookie('SynergyPartner');
				}
			}

			/*Для synergyglobal  Partner в куки - приоритетнее, чем get-параметре */
			if (window.location.hostname == 'synergyglobal.ru') {
				if (LANDER.get_cookie('GlobalPartner') !== undefined || LANDER.get_cookie('GlobalPartner') !== null) {
					partner = LANDER.get_cookie('GlobalPartner');
				}
			}

			/* Для synergy и synergyonline собираем  url (затем вставим в hidden-поле формы) из текущих get-параметров + utm-меток из cookie */
			if (window.location.hostname.indexOf('synergy.ru') != -1 || window.location.hostname.indexOf('synergyonline.ru') != -1 || window.location.hostname.indexOf('synergy.mba') != -1  || window.location.hostname.indexOf('sbs.edu.ru')  != -1 || window.location.hostname.indexOf('mosap.ru')  != -1 || window.location.hostname.indexOf('universitetsadovodov.ru')  != -1) {
				if (document.cookie.indexOf('utm_') != -1) {
					var utmArr = ['utm_source','utm_medium','utm_campaign','utm_content','utm_term'];
					var get_params = LANDER.URLToArray(window.location.search);

					for (var i = 0, len = utmArr.length; i < len; i++) {
						var utm_cookie = LANDER.get_cookie(utmArr[i]);
						if (utm_cookie !== undefined && utm_cookie !== null) {
							get_params[utmArr[i]] = utm_cookie;
						}
					}
					var param_str = '';
					for (var par in get_params) {
						param_str +=  par + "=" + get_params[par] + '&';
					}
					var url = document.location.protocol + '//' + document.location.hostname + document.location.pathname + '?' + param_str;
				}
			}


			if (partner)       $form.append('<input type="hidden" name="partner" value="' + partner + '">');
			if (refer)         $form.append('<input type="hidden" name="refer" value="' + refer + '">');
			if (cost)          $form.append('<input type="hidden" name="cost" value="' + cost + '">');
			if (bitrix)        $form.append('<input type="hidden" name="bitrix" value="' + bitrix + '">');
			if (onlinepay) 	   $form.append('<input type="hidden" name="onlinepay" value="1">');
			var UNIX_TIMESTAMP = Math.round(new Date().getTime() / 1000);
			if (mergelead) {
				$form.append('<input type="hidden" name="mergelead" value="'+guid+UNIX_TIMESTAMP+'">');
			} else if ($form.find('[name=cost]').val()) {
				$form.append('<input type="hidden" name="mergelead" value="'+guid+UNIX_TIMESTAMP+'">');
			}
			/*if (true) 	   	$form.append('<input type="hidden" name="mergelead" value="'+guid+UNIX_TIMESTAMP+'">');*/
			if (url)        $form.append('<input type="hidden" name="url" value="' + url + '">');

			/*if (PHPSESSID)          $form.append('<input type="hidden" name="PHPSESSID" value="' + PHPSESSID + '">');*/
			/*if (PAPVisitorId)  $form.append('<input type="hidden" name="PAPVisitorId" value="' + PAPVisitorId + '">');*/
			/*if (roistat_visit) $form.append('<input type="hidden" name="roistat_visit" value="' + roistat_visit + '">');*/
			/*if (analytics_id)  $form.append('<input type="hidden" name="analytics_id" value="' + analytics_id + '">');*/

			/* Отправка данных в GTM */
			dataLayer.push(
				{'gtm.element.dataset.guid': guid},
				{'gtm.element.dataset.landname': landname},
				{'gtm.element.dataset.version': version},
				{'gtm.element.dataset.form': form},
				{'gtm.element.dataset.phone': phone},
				{'gtm.element.dataset.phone_md5': LANDER.md5(phone)},
				{'gtm.element.dataset.email': email},
				{'gtm.element.dataset.email_md5': LANDER.md5(email)},
				{'gtm.element.dataset.cost': cost},
				{'gtm.element.dataset.partner': partner},
				{'gtm.element.dataset.land': land},
				{'gtm.element.dataset.speaker': speaker},
				{'gtm.element.dataset.program': program},
				{'gtm.element.dataset.dater': dater},
				{'gtm.element.dataset.type': type},
				{'gtm.element.dataset.link': link}
				)
			;

			/* Запись данных */
			var
			name_input  = $form.find('[name=name]'),
			phone_input = $form.find('[name=phone]'),
			email_input = $form.find('[name=email]'),
			select      = $form.find('select[name=exam]')
			;

			if (name_input.length)  localStorage.setItem('name', name);
			if (phone_input.length) localStorage.setItem('phone', phone);
			if (email_input.length) localStorage.setItem('email', email);
			if (select.val())       localStorage.setItem('exam', select.val());

			return false;
		})
		// Показать системную информацию по Ctrl+Click
		.on('click', function (e) {

			if (e.ctrlKey || e.metaKey) {
				var
				systeminfo = '',
				clearqueryCtrl = $(this).attr('action').split('?'),
				superqueryCtrl = clearqueryCtrl[1],
				splitterCtrl = superqueryCtrl.split('&')
				;

				var generateLandHelper = {};

				splitterCtrl.forEach(function (entry) {
					var keys = entry.split('=');
					if (!keys[0]) return;
					systeminfo += '<tr><td>' + keys[0] + ':</td><td>' + decodeURIComponent(keys[1]) + '</td></tr>';
					generateLandHelper[ keys[0] ] = keys[1];
				});
				/* формируем поле generate-land как оно генерируется на бэкенде */
				var land_path = window.location.pathname.replace(/^\//g, "");

				if(land_path[land_path.length-1] == "/"){

					land_path = land_path.replace(/\/$/g, "");

				}
				else{

					if(land_path.indexOf(".") >= 0){

						land_path = land_path.split("/");
						land_path.splice([land_path.length-1], 1);
						land_path = land_path.join("/");

					}

				}

				land_path = land_path.replace(/\//g, "_");
				/*var get = window.location.search.slice(1);
				get = get.split("&");
				var gets = {};
				for(var i = 0; i < get.length; i++){
					var param = get[i].split("=")[0];
					var value = get[i].split("=")[1];
					gets[param] = value;
				}*/
				generateLandHelper["version"] = typeof generateLandHelper["version"] != 'undefined' ? "__" + generateLandHelper["version"] : "";
				generateLandHelper["partner"] = typeof generateLandHelper["partner"] != 'undefined' ? "--" + generateLandHelper["partner"] : "";
				systeminfo += '<tr><td>generate-land:</td><td>' + land_path + generateLandHelper["version"] + generateLandHelper["partner"] + '</td></tr>';
				/* Показываем красивый алерт с системной информацией */
				$('body').append('<div id="lander-form-system-info" style="z-index: 99999; display: table; width: 100%; height: 100%; position: fixed; left:0; top:0"><style>#lander-form-system-info td{width:48%;text-align:right;padding-right:10px;font-weight:bold;}#lander-form-system-info td+td{width:50%;text-align:left;font-weight:normal;}</style><div style="display: table-cell; vertical-align: middle; text-align: center;"><div style="background: rgb(255, 255, 255); min-width: 500px; padding: 10px 20px 20px; border-radius: 5px; text-align: center; display: inline-block; margin: 0 auto; box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);"><h2 style="color: #575757;font-size: 30px;text-align: center;font-weight: 600;text-transform: none;position: relative;margin: 10px 0 25px;padding: 0;line-height: 40px;display: block;">Системная информация</h2><table style="color: #575757;font-size: 16px;" width="100%">' + systeminfo + '</table><div class="sa-button-container"> <button style="color: rgb(255, 255, 255); border: medium none; font-size: 18px; font-weight: 500; border-radius: 5px; line-height: 44px; cursor: pointer; margin-top: 35px; padding: 0 15px; display: inline-block; background-color: rgb(174, 222, 244); box-shadow: 0 0 2px rgba(174, 222, 244, 0.8), 0 0 0 1px rgba(0, 0, 0, 0.05) inset;" >Закрыть</button></div></div></div></div>');
				$(document).on('click', '#lander-form-system-info button', function(){
					$('#lander-form-system-info').remove();
					return false;
				});
			}
		})
		.each(function () {
			var $form = $(this);
			if ($form.data('inited') == 'inited') return;

			/* Кодирование кириллицы в action форм для IE */
			LANDER.encodeFormAction($form);

			$form.data('inited', 'inited');
		})
		/* После перезагрузки страницы у элементов форм убираем атрибут disabled="", установленный ранее через .attr(), и не трогаем те, которые по умолчанию имеют явно указанный атрибут disabled */
		.find(':input:not([disabled])').removeAttr('disabled')
		;

		/* Подстановка данных из локальной БД пользователя. Не подставляем в поля с классом ignore-storage */
		if (localStorage.getItem('name'))  {$('[name=name]:not(.ignore-storage)').val(localStorage.getItem('name')).trigger('change').addClass('GoodLocal');}
		if (localStorage.getItem('phone')) {$('[name=phone]:not(.ignore-storage)').val(localStorage.getItem('phone')).trigger('change');}
		if (localStorage.getItem('email')) {$('[name=email]:not(.ignore-storage)').val(localStorage.getItem('email')).trigger('change');}
	};

	/* Автоматическая подстановка маски под номер телефона */
	LANDER.inputMasks = function() {
		if (typeof $.fn.inputmask == 'undefined') {
			LANDER.loadJS( '//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.3/jquery.inputmask.bundle.min.js', function(){ /* Плагин маски со встроенным расширением для телефонов */
				LANDER.loadJS( '//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.3/phone-codes/phone.js', function(){ /* Дефолтные маски телефонов плагина */
					LANDER.loadJS( '//synergy.ru/lander/alm/js/phone-addon.js', LANDER.inputMasks ); /* Дополнительные собственные маски телефонов */
				});
			});
			return;
		}

		$('[name="phone"]:not([data-inputmasks-inited]), [type="tel"]:not([data-inputmasks-inited])').each(function() {

			/* Фикс для бага inputmask на Android (после ввода первой цифры или наличия скобки в маске номера каретка не смещается вправо) //github.com/RobinHerbots/Inputmask/issues/1490#issuecomment-274939324 */
			if ( navigator.userAgent.match(/Android/i) ) {
				$(this).attr('type', 'text');
			}

			$(this).inputmask({
				alias: 'phone',
				url: '//synergy.ru/lander/alm/js/phone-codes.json' /* Параметр url для лендов, на которых подключена старая версия inputmask */
			}).attr('data-inputmasks-inited', '');

		});
	};

	LANDER.formValidationMethod = function() {
		/* Дополнительный метод валидации имени */
		$.validator.addMethod('valname', function (value, element) {
			return this.optional(element) || /^[А-Яа-яЁёA-Za-z\s]{2,100}$/.test(value);
		}, (GLOBAL_LANG == 'ru' ? 'Введите корректное имя' : 'Please enter a valid name') );

		/* Дополнительный метод валидации e-mail */
		$.validator.addMethod('valemail', function (value, element) {
			return this.optional(element) || /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(value);
		}, (GLOBAL_LANG == 'ru' ? 'Введите корректный e-mail' : 'Please enter a valid email') );

		/* Дополнительный метод валидации телефона на заполненность маски */
		$.validator.addMethod('valphone', function (value, element) {
			return this.optional(element) || $(element).inputmask('isComplete');
		}, (GLOBAL_LANG == 'ru' ? 'Введите корректный телефон' : 'Please enter a valid phone') );

		/* Перевод валидации на русский язык */
		if ( GLOBAL_LANG == 'ru' ) {
			$.extend($.validator.messages, {
				required : 'Обязательное поле',
				remote   : 'Пожалуйста, введите правильное значение.',
				email    : 'Пожалуйста, введите корректный адрес E-mail.',
				number   : 'Пожалуйста, введите цифры.',
				maxlength: $.validator.format('Пожалуйста, введите не больше {0} символов.'),
				minlength: $.validator.format('Пожалуйста, введите не меньше {0} символов.')
			});
		}
	};

	/* Добавление хэшей в URL */
	LANDER.Hash = {
		/* Получаем хэш объектом */
		get : function () {
			var vars   = {}, hash;
			var hashes = decodeURIComponent(window.location.hash.substr(1));
			if (hashes.length == 0) {
				return vars;
			}
			else {
				hashes = hashes.split('/');
			}
			for (var i in hashes) {
				hash = hashes[i].split('=');
				if (typeof hash[1] == 'undefined') {
					vars['anchor'] = hash[0];
				}
				else {
					vars[hash[0]] = hash[1];
				}
			}
			return vars;
		}
		/* Выставляем хэш из объекта */
		, set   : function (vars) {
			var hash = '';
			for (var i in vars) {
				hash += '/' + i + '=' + vars[i]
			}
			window.location.hash = hash.substr(1);
		}
		/* Добавляем значение в хэш */
		, add   : function (key, val) {
			var hash  = this.get();
			hash[key] = val;
			this.set(hash);
		}
		/* Убираем значение из хэша */
		, remove: function (key) {
			var hash = this.get();
			delete hash[key];
			this.set(hash);
		}
		/* Очистка хэша */
		, clear : function () {
			window.location.hash = '';
		}
	};

	window.Hash = LANDER.Hash;

	/* Поля формы */
	LANDER.formFields = function(form) {
		var fields = {};
		$(form).find('input,select,textarea').not('[type=submit]').each(function(){
			if($(this).attr('name') && $(this).attr('name') != 'radio')
				fields[$(this).attr('name')] = $(this).val();

			if($(this).attr('name') == 'radio' && $(this).prop("checked"))
				fields['radio'] = $(this).val();
		});

		return fields;
	};


	/* Верификация SMS формы */
	LANDER.formSmsVer = function(form) {
		$(document).on('submit', form, function(){
			var fields = LANDER.formFields(form);

			$.ajax({
				url   : $(form).attr('action'),
				method: "POST",
				data  : fields
			}).done(function(data){
				$(form).trigger('send-success').parents('.send-success').parent().html(data);
			});
			return false;
		});
	};

	/* duplicate формы */
	LANDER.formDuplicate = function(form) {
		$(document).on('submit', form, function(){
			var fields = LANDER.formFields(form);

			$.ajax({
				url   : $(this).attr('action'),
				method: "POST",
				data  : fields
			}).done(function(data){
				$(form).parents('.send-duplicate').replaceWith(data);

				if ($('[data-form=smsver]').length) {
					LANDER.formSmsVer('[data-form=smsver]');
				}
			});
			return false;
		});
	};

	/* Повторная отправка капчи, используется в lander.php в data-callback для google recaptcha */
	LANDER.recaptchaCallback = function() {
		$('#duplicate-capcha :submit').addClass('recaptcha-success');
	};

	LANDER.initAutoSubmit = function(){

		var uris = [
			'synergy.ru',
			'synergyonline.ru',
		];

		var uriValid = false;
		var uri = window.location.origin + window.location.pathname + window.location.search;

		for(var i in uris){

			var reg = new RegExp(uris[i], 'gi');

			if( reg.test(uri) ){

				uriValid = true; 
				break;

			}

		}

		if(uriValid){
		//if(true){

			$(document).on('focusout', 'form', function(ev){

				ev.preventDefault();

				var $form = $(this);

				if(!$form.find('input[name="email"]').val()) return;

				if(!$form.data('auto-submit-block')){

					$form.data('auto-submit-block', true);

					var data = $form.serializeArray();
					var action = $form.attr('action');

					data.push({
						name: 'url',
						value: uri
					});

					data.push({
						name: 'action',
						value: action
					});

					$.ajax({

						url: 'https://syn.su/v3/?r=dump',
						method: 'POST',
						data: data,
						dataType: 'JSON',
						success: function(){

							$form.data('auto-submit-block', false);

						}

					});

				} else return;

			})

		}

	}

	/* Валидация формы */
	LANDER.formValidation = function() {
		if (typeof $.validator == 'undefined') {
			LANDER.loadJS( '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js', LANDER.formValidation );
			return;
		}

		LANDER.formValidationMethod();

		/* Валидация и аякс отправка форм с смс-верификацией */
		$('form').not('#mse2_form, .nolander').each(function(){
			var
			$form = $(this),
			lang = $form.attr('data-lang') || GLOBAL_LANG
			;

			/* Замена partner в action форм, если партнер есть в cookie */
			if (window.location.hostname == 'sbs.edu.ru' || window.location.hostname == 'synergyregions.ru') {
				if (LANDER.get_cookie('SynergyPartner') !== undefined && LANDER.get_cookie('SynergyPartner') !== null) {
					if (LANDER.getQuery('partner') !== false && LANDER.getQuery('partner') != null && LANDER.getQuery('partner') != '') {
						var
						sub_actions = $form.attr('action'),
						replace_sub_actions = sub_actions.replace('partner=' + LANDER.getQuery('partner'), 'partner=' + LANDER.get_cookie('SynergyPartner'))
						;
					} else {
						var
						sub_actions = $form.attr('action'),
						replace_sub_actions = sub_actions.replace('partner=', 'partner=' + LANDER.get_cookie('SynergyPartner'))
						;
					}
					$form.attr('action', replace_sub_actions);
				}
			}

			/* Смена типа ленда "type" на подписной, если есть параметр */
			if(LANDER.getQuery('type') == 'sub') {
				var
				sub_type = 'type=' + LANDER.getQuery('type'),
				sub_action = $form.attr('action'),
				replace_sub_action = sub_action.replace('type=mk', sub_type)
				;

				$form.attr('action', replace_sub_action);
			}

			$form.validate({
				errorElement: "label",
				rules: {
					"name": {required: true, minlength: 2, maxlength: 50, valname: (lang != 'cn' ? true : false)},
					"phone": {required: true, minlength: 11, maxlength: 25, valphone: true},
					'email': {required: true, email: true, valemail: true},
					'number':{required: true, number: true, min: 1}
				},
				/* Ajax отправка формы */
				submitHandler: function (form) {

					var piwik_id2 = LANDER.get_piwik_cookie('_pk_id');
					var PAPVisitorId  = LANDER.get_cookie('PAPVisitorId');
					var roistat_visit = LANDER.get_cookie('roistat_visit');
					var analytics_id  = LANDER.get_cookie('_ga');
					/*var PHPSESSID  = LANDER.get_cookie('PHPSESSID');*/

					if (piwik_id) $(form).append('<input type="hidden" name="piwik_id" value="' + piwik_id + '">');
					if (PAPVisitorId)  $form.append('<input type="hidden" name="PAPVisitorId" value="' + PAPVisitorId + '">');
					if (roistat_visit) $form.append('<input type="hidden" name="roistat_visit" value="' + roistat_visit + '">');
					if (analytics_id)  $form.append('<input type="hidden" name="analytics_id" value="' + analytics_id + '">');
					/*if (PHPSESSID)  $form.append('<input type="hidden" name="PHPSESSID" value="' + PHPSESSID + '">');*/


					var
					target = $(form).is('.notarget') ? $(form).find('.target').attr('action') : $(form).attr('action'),
					fields = LANDER.formFields(form)
					;

					target = target.replace('syn.su', 'synergy.ru/lander/alm')

					var valSubmit = $(form).find(':submit').val();

					/* Блокирование полей и кнопки формы */
					$(form).find('input:not([disabled="disabled"])').attr('disabled', '');
					$(form).find(':submit').attr({
						'disabled': '',
						'value'   : TRANSLATE[lang]['sending']
					}).addClass('loading');

					$.ajax({
						url   : target,
						method: 'POST',
						data  : fields
					})
					.done(function(data) {
						LANDER.Hash.add('send','ok');
						/*console.log('1');*/
						dataLayer.push({'event': 'gtm.formSubmit'});
						/*dataLayerTest.push({'event': 'gtm.formSubmit'});*/

						if(data!='') {
							$(form).html(data);

							

							var
							smsver = $('[data-form=smsver]'),
							dcap   = $('#duplicate-capcha')
							;

							if (smsver.length || dcap.length) {
								if (smsver.length)
									form = smsver;
								if (dcap.length)
									form = dcap;

								form
								.on('submit', function () {
									fields = LANDER.formFields(form);

									$.ajax({
										url: $(this).attr('action'),
										method: "POST",
										data: fields
									})
									.done(function (data) {
										if ($('.send-duplicate').length) {
											$('.send-duplicate').parents('form').replaceWith(data);

											if ($('[data-form=smsver]').length)
												LANDER.formSmsVer('[data-form=smsver]');
											else
												LANDER.formDuplicate('#duplicate-capcha');
										} else {
											form.html(data);

											var $body = $('body');
											if ($body.is('#proftest') || $body.is('#ege')) {
												localStorage.setItem('verification', 'success');
											}
											$body.trigger('init-test');
										}
									});
									return false;
								});
							}
						}
						else{
							$(form).find('input:not([disabled="disabled"]), :submit').removeAttr('disabled');
							$(form).find(':submit').val(valSubmit).removeClass('loading');
						}

						$(form).trigger('send-success');

						if($('.target').length)
							$(form).find('.target').show();
					})
					.fail(function(data){

						if(/varchugov/i.test(window.location.href)){

							$('body').html(JSON.stringify(data));

						}

					});

					return false;
				}
			})
		});
		// LANDER.formValidation
	};

	/* Интеграция Outlineagency. #84316 */
	LANDER.outlineagency = function() {
		if( !location.search ) return;
		/* remove '?' and make array */
		var s = location.search.substr(1),
		s_arr = s.split('&'),
		utm_content = 'utm_content';


		$.each(s_arr, function(k, v){
			if(v.match(/utm_content/)) {
				var utm_contentVal = v.split('=')[1];
				if( utm_contentVal.charAt(0) != '{' ) {
					document.cookie = "utm_content=" + v.split('=')[1];
				}
			}
		});
	};

	/* Начальная инициализация сетки для отладки */
	LANDER.grid = function() {
		var width_grid = 960;

		if( $('.container').length && $('.row').length ) {
			width_grid = $('.container:first').width();
		}
		else if( $('.inner').length ) {
			width_grid = $('.inner:first').width();
		}

		$('head').append('<style>.grid-tool_active_yes{height:auto;position:relative;}.grid-tool_active_yes::after{width:'+width_grid+'px;content:"";position:absolute;top:0;bottom:0;left:50%;z-index:10000;margin-left:-'+parseInt(width_grid/2-1)+'px;background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAASBAMAAADbMYGVAAAAD1BMVEX+SBn+SBn/q5X/cU3////7dpXTAAAABXRSTlNGWUZKJg9ROHAAAAAZSURBVHgBY2QAAUEQ8R5EKIGIISOoNIQFAYpaFan+ujdTAAAAAElFTkSuQmCC");}</style>');

		if (localStorage.getItem('grid-tool') == 'yes') {
			$('body').toggleClass('grid-tool_active_yes');
		}

		/* Выводит сетку для теста верстки по Ctrl+Shift+Alt */
		$(document).on('keydown', function(event) {
			if(event.ctrlKey == 1 && event.shiftKey == 1 && event.altKey == 1) {
				localStorage.setItem('grid-tool', localStorage.getItem('grid-tool') != 'yes' ? 'yes' : 'no' );
				$('body').toggleClass('grid-tool_active_yes');
			}
		});
	};

	/* dev режим */
	LANDER.devCookie = function() {

		$(document).on('keydown', function(event) {

			if(event.shiftKey == 1 && event.altKey == 1 && event.keyCode == 68) {

				if(LANDER.get_cookie('original')){

					LANDER.set_cookie('original', "", {expires: -1});
					console.log('dev режим выключен');
					window.location.reload();

				} else {

					LANDER.set_cookie('original', "1", {expires: Date.now() + 1000 * 60 * 10});
					console.log('dev режим включен');
					window.location.reload();

				}

			}

		});

	};

	/* очистить кэщ cdn */
	LANDER.clearCNDcache = function() {

		setTimeout(function(){LANDER.set_cookie('clearcache', "", {expires: -1});}, 2000);

		$(document).on('keydown', function(event) {

			if(event.shiftKey == 1 && event.altKey == 1 && event.keyCode == 67) {

				LANDER.set_cookie('clearcache', "1");
				window.location.reload();

			}

		});

	};

	/* Подгрузка Пользовательского соглашения  */
	LANDER.privacy = function() {
		function initFancyPrivacy() {
			var
			$links = $('.privacy-ajax, a[href*="#privacy"]'),
			font_family = $('body').css('font-family')
			;

			$links
			.attr('href', '//synergy.ru/lp/_chunk/privacy.php?date=28-04-2017&lang=' + GLOBAL_LANG)
			.removeClass('fancy fancybox')
			.addClass('fancybox-privacy-link')
			;

			$('.fancybox-privacy-link').fancybox({
				type: 'ajax',
				maxWidth: 910,
				autoResize: true,
				padding: 0,
				wrapCSS: 'fancybox-privacy',
				helpers: {
					overlay: {
						locked: false
					}
				}
			});

			if ( font_family.search(/exo/i) == -1 ) {
				$('head').append('<link href="//fonts.googleapis.com/css?family=Exo+2:300,500,600" rel="stylesheet">');
			}
		}

		function initCheckboxPrivacy() {
			/* Запускаем хелпер только для synergy.ru, synergyonline.ru, synergysport.ru */
			if (
				location.hostname.indexOf('synergy.ru') == -1
				&& location.hostname.indexOf('synergyonline.ru') == -1
				&& location.hostname.indexOf('synergysport.ru') == -1
				&& location.hostname.indexOf('synergydigital.ru') == -1
				&& location.hostname.indexOf('gozoboronzakaz.ru') == -1
				&& location.hostname.indexOf('synergyglobal.com') == -1
				)
				return;

			$('head').append('<style>.widget-form-privacy { overflow: hidden !important; clear: both !important; } .widget-form-privacy__content {position: relative !important; z-index: 1 !important; clear: both !important; overflow: visible !important; text-align: left !important; color: #000 !important; font-size: 13px !important; line-height: 1.2 !important; border: 1px solid rgba(0,0,0,0.1) !important; background: rgba(255,255,255,0.7) !important; padding: 20px 20px 20px 40px !important; margin: 10px 0 !important; } .widget-form-privacy__checkbox {width: auto !important; position: absolute !important; top: 23px !important; left: 20px !important; opacity: 1 !important; padding: 0 !important; margin: 0 !important; cursor: pointer; } [type="submit"][disabled] { cursor: not-allowed !important; opacity: 0.5; } .widget-form-privacy__link { display: inline !important; vertical-align: baseline !important; font-size: inherit !important; color: inherit !important; text-decoration: underline !important; } .widget-form-privacy .ui-checkbox {margin: 0 !important; }.widget-form-privacy label{color:inherit !important;background: none;display:inline !important;padding:0 !important;margin: 0 !important;font-size: inherit !important;}</style>');

			$('form:not(.nolander)').each(function(){
				var $form = $(this);

				/* Добавляем в форму ссылку с чекбоксом, только если их еще нет */
				if ( $(':checkbox[name="personalDataAgree"], a[href*="privacy"], div.widget-form-privacy', $form).length ) return;

				var checboxId = 'privacycheckbox-id-'+Date.now();

				var
				lang = $form.attr('data-lang') || GLOBAL_LANG,
				privacy_text = '<label for="'+checboxId+'">Я&nbsp;даю согласие на&nbsp;обработку персональных данных, согласен на&nbsp;получение информационных рассылок от&nbsp;Университета «Синергия» и&nbsp;соглашаюсь c&nbsp;<a href="//synergy.ru/lp/_chunk/privacy.php" target="_blank" class="widget-form-privacy__link fancybox-privacy-link">политикой конфиденциальности</a>.</label>'
				;

				if (lang == 'en') {
					privacy_text = '<label for="'+checboxId+'">I&nbsp;give my&nbsp;consent to&nbsp;the processing of&nbsp;personal data, I&nbsp;also agree to&nbsp;receivе information updates from the Synergy University and agree to&nbsp;the <a href="//synergy.ru/lp/_chunk/privacy.php?lang=en" target="_blank" class="widget-form-privacy__link fancybox-privacy-link">privacy policy</a>.</label>';
				}

				$form.append('<div class="widget-form-privacy"><div class="widget-form-privacy__content"><input type="checkbox" name="personalDataAgree" id="'+checboxId+'" checked="" class="widget-form-privacy__checkbox"> ' + privacy_text + '</div></div>');
			});

			/* Проверяем чекбокс, дизаблим/раздизабливаем кнопку */
			$(document).on('change', ':checkbox[name="personalDataAgree"]', function() {
				var $form = $(this).closest('form');

				if ( this.checked ) {
					$(':submit', $form).removeAttr('disabled');
				}
				else {
					$(':submit', $form).attr('disabled', 'disabled');
				}
			});
		}

		initCheckboxPrivacy();

		if (!$.fn.fancybox) {
			LANDER.loadJS( '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js', initFancyPrivacy );
			$('head').append('<link href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet">');
		} else {
			initFancyPrivacy();
		}
	};


	/* Подгрузка скрипта и выполнение функции после его загрузки  */
	LANDER.loadJS = function(js_file, js_function) {
		var script = document.createElement('script');
		script.src = js_file;
		document.body.appendChild(script);
		script.onload = function () {
			if (!this.executed) { /* Выполнится только один раз*/
				this.executed = true;
				if (js_function) js_function.call();
			}
		};
		script.onreadystatechange = function () {
			var self = this; /* Сохранить "this" для onload */
			if (this.readyState == "complete" || this.readyState == "loaded") {
				setTimeout(function () {
					self.onload()
				}, 0);
			}
		};
	};

	LANDER.check();

	return LANDER;
})();
