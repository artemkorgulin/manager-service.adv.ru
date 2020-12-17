"use strict";

namespace LANDER{

/**
 * browser check
 */
(function() {

	if(![].forEach || !window.addEventListener){

		// TODO: там css заменить на свои
		window.location.href="http://lander3/public/front/pages/badbrowser.php";

	}

})();

/**
 * gtm
 */
(function(){
	
	let gtm:any = document.createElement('script');
	
	// TODO: это будет лежать на продакшне статично
	gtm.src = 'http://lander3/public/front/js/gtm.min.js';

	console.log(Date.now());

	document.head.appendChild(gtm);

})();

export type assoc = {[key:string]:any|assoc};

declare let $:any;
declare let md5:any;
declare let url:any;
declare let cookie:any;

class Lander{

	private ga:any;
	private dictionary:assoc;
	private currentLanguage:assoc;
	private depedences:assoc[];
	private requiredResources:string[];
	private lang:string;
	private widgets:assoc;
	private params:assoc;
	url:assoc;
	user:assoc;
	inited:boolean;

	/**
	 * определение стандартных параметров
	 * @param {any = []} ga [description]
	 */
	constructor(ga:any = []){

		console.log(Date.now());

		this.ga = ga;

		this.setLanderParams();

		/**
		 * Фразочки
		 * @type {Object}
		 */
		this.dictionary = {

			ru: {
				sending: 'Отправка...',
				widgetFormPrivacyLabel: 'Я&nbsp;даю согласие на&nbsp;обработку персональных данных, согласен на&nbsp;получение информационных рассылок от&nbsp;Университета «Синергия» и&nbsp;соглашаюсь c&nbsp;<a href="#privacy" class="lander-widget-form-privacy__link">политикой конфиденциальности</a>.',
				requiredField: 'Обязательное поле',
				invalidName: 'Введите корректное имя',
				invalidPhone: 'Введите корректный телефон',
				invalidEmail: 'Введите корректный адрес E-mail',
				invalidMask: 'Введите корректное значение',
				invalidNumber: 'Это поле может содержать только цифры'
			},
			en: {
				sending: 'Sending...',
				widgetFormPrivacyLabel: 'I&nbsp;give my&nbsp;consent to&nbsp;the processing of&nbsp;personal data, I&nbsp;also agree to&nbsp;receivе information updates from the Synergy University and agree to&nbsp;the <a href="#privacy" class="lander-widget-form-privacy__link">privacy policy</a>.',
				requiredField: 'Field is required',
				invalidName: 'Please enter a&nbsp;valid name',
				invalidPhone: 'Please enter a&nbsp;valid phone',
				invalidEmail: 'Please enter a&nbsp;valid email',
				invalidMask: 'Please enter a&nbsp;valid value',
				invalidNumber: 'Это поле может содержать только цифры'
			},
			kz: {
				sending: 'Жіберу...'
			},
			cn: {
				sending: '发送'
			},
			es: {
				sending: 'Envío...'
			}

		};

		/**
		 * Зависимости
		 * @type {Array}
		 */
		this.depedences = [

			{

				name: 'jQuery',
				url: 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',
				required: true,
				check: typeof (<any>window).jQuery == 'function',
				afterLoad: function(){


				},
				childrens: [

					{

						name: 'inputmask',
						url: 'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js',
						required: true,
						check: typeof (<any>window).jQuery == 'function' && $.fn.inputmask,
						childrens: [

							{

								name: 'phoneCodes',
								url: 'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/phone-codes/phone.min.js',
								childrens: [],
								required: true,
								loaded: false,

							},
							{

								name: 'phoneCodesAddon',
								url: 'https://syn.su/js/phone-addon.js', // TODO
								childrens: [],
								required: true,
								loaded: false,

							},

						],
						loaded: false,

					},
					{

						name: 'fancybox',
						url: 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/js/jquery.fancybox.min.js',
						required: true,
						check: typeof (<any>window).jQuery == 'function' && (<any>window).jQuery.fn.fancybox,
						childrens: [],
						loaded: false,

					},

				],
				loaded: false,

			},
			{

				name: 'url',
				url: 'https://cdnjs.cloudflare.com/ajax/libs/js-url/2.5.0/url.min.js',
				required: true,
				check: (<any>window).url,
				childrens: [],
				loaded: false,

			},
			{

				name: 'cookie',
				url: 'https://cdnjs.cloudflare.com/ajax/libs/cookie.js/1.2.2/cookie.min.js',
				required: true,
				check: (<any>window).cookie,
				childrens: [],
				loaded: false,

			},
			{

				name: 'md5',
				url: 'https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.8.0/js/md5.min.js',
				required: true,
				check: (<any>window).md5,
				childrens: [],
				loaded: false,

			},
			{

				name: 'fancyboxCss',
				url: 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/css/jquery.fancybox.min.css',
				childrens: [],
				check: typeof (<any>window).jQuery == 'function' && (<any>window).jQuery.fn.fancybox,
				loaded: false,

			},
			{

				name: 'landerCss',
				url: `${this.params.baseUrl}/css/lander.css`, // TODO
				childrens: [],
				loaded: false,

			}

		];

		/**
		 * Разметка виджетов
		 * @type {Object}
		 */
		this.widgets = {

			formPrivacy: '\
				<div class="lander-widget-form-privacy">\
					<div class="lander-widget-form-privacy__content">\
						<input \
							type="checkbox" \
							name="personalDataAgree"\
							class="lander-widget-form-privacy__checkbox">\
						<label class="lander-widget-form-privacy__label"></label>\
					</div>\
				</div>\
			',
			formInfo: '\
				<table class="lander-widget-form-info"></table>\
			'

		}

		this.lang = this.getDocumentLanguage();
		this.setLanderLang(this.lang);

		this.requiredResources = [];
		this.resourcesMap(this.depedences);
		this.loadResources(this.depedences);

	}

	/**
	 * Достает из тега-скрипта лендера параметры
	 * @return {assoc} [description]
	 */
	private setLanderParams():assoc{

		let scriptTag:any = document.querySelector('script[src*="lander"]');
	
		let paramsArr:string[] = scriptTag.dataset.landerOptions.split(',');
		let params:assoc = [];

		for(let i = 0; i < paramsArr.length; i++){

			if(!paramsArr[i]) continue;
			let split = paramsArr[i].split('=');

			params[ split[0] ] = split[1];

		}

		this.params = {

			action: params.action || 'https://syn.su/lander.php',
			dev: params.dev || false,
			baseUrl: params.baseUrl || 'https://syn.su'

		};

		return this.params;

	}

	/**
	 * запускается после загрузки всех зависимостей, равносильно старому init()
	 * @return {Lander} [description]
	 */
	private start():Lander{

		if(this.inited) return this;

		this.initUrl();
		this.initUser();
		this.checkRegion();

		this
			.setDomainCookies()
			.initForms()
			.initPrivacyLinks()
			.initFormPrivacyListener()
			.validateFormListener()
			.initFormSubmit()
			.initFormHelper()
			.initUtils()

		if(this.params.dev){ 

			this.initDevTools();

		}

		this.initAutoSubmit();

		this.inited = true;

		return this;

	}

	/**
	 * Дефолтные скрипты из стандартного common.js большинства лендов
	 * @return {Lander} [description]
	 */
	private initUtils():Lander{

		this
			.initDefaultFancybox()
			.initDefaultScroll();

		return this;

	}

	/**
	 * Дефолтный fancybox
	 * @return {Lander} [description]
	 */
	private initDefaultFancybox():Lander{

		$(document).on('click', '.lander-fancybox', (ev:any)=>{

			let $el = $(ev.currentTarget);

			$.fancybox($el, {

				maxWidth: 1200,
				autoResize: true,
				helpers: {
					media: {},
					overlay: {
						locked: false
					}
				}

			});

			return false;

		})

		return this;

	}

	/**
	 * Дефолтный плавный скролл
	 * @return {Lander} [description]
	 */
	private initDefaultScroll():Lander{

		$(document).on('click', '.lander-scroll', (ev:any)=>{

			let $el = $(ev.currentTarget);

			let $target = $( $el.attr('href') );

			if(!$target.length) return;

			let posTop:number = $target.offset().top;
			$('html, body').animate({scrollTop: posTop}, 1000);

			return false;

		})

		return this;

	}

	/**
	 * инициализация форм
	 * берет все формы кроме тех у кого установлен класс:
	 * lander-off или 
	 * lander-inited (уже проинициализирована)
	 * @param {any = $(document)} $context контекст, где искать форму которые нужно проинициализировать
	 * @return {Lander} [description]
	 */
	initForms($context:any = $(document)):Lander{

		/*
			TODO: класс .nolander устарел. Вместо него будет использоваться lander-off
		 */
		let $forms = $('form:not(.lander-off):not(.lander-inited)', $context);

		$forms.each((index:number, el:any)=>{

			let $form:any = $(el);

			this.initFormInputs($form);

			// чекбокс с политикой включается только на доменах из условия
			if(/synergy.ru|synergyonline.ru|examples/i.test(window.location.hostname)){ // TODO: examples - dev версия

				this.initFormPrivacy($form);

			}

			$form.addClass('lander-inited');

		});

		return this;

	}

	/**
	 * инициализация инпутов внутри формы
	 * @param {any} $form [description]
	 * @return {Lander} [description]
	 */
	initFormInputs($form:any):Lander{

		let $name = $('[name="name"]', $form);
		let $phone = $('[name="phone"]', $form);
		let $email = $('[name="email"]', $form);

		$phone
			.filter(':not(data-lander-inputmask-inited)')
			.attr('type', 'text')
			.inputmask({ alias: 'phone' })
			.attr('data-lander-inputmask-inited', true);

		$name.val( this.getUserProp('name') );
		$phone.val( this.getUserProp('phone') );
		$email.val( this.getUserProp('email') );

		return this;

	}

	/**
	 * добавляет к форме чекбокс с политикой конфиделнциальности
	 * @param {any} $form [description]
	 * @return {Lander} [description]
	 */
	initFormPrivacy($form:any):Lander{

		/*
			TODO: сделать возможность применять 2 чекбокса отдельно: политика и рассылки
		 */

		$form = $form.filter(':not(.lander-privacy-off):not(.lander-privacy-inited)');

		// если есть свой чекбокс у формы
		let $currentWidgets = $('[name="personalDataAgree"]', $form);

		if($form.length < 1 || $currentWidgets.length > 0){

			return this;

		}

		let $widget = $(this.widgets.formPrivacy);

		let $widget__checkbox = $('.lander-widget-form-privacy__checkbox', $widget);
		let $widget__label = $('.lander-widget-form-privacy__label', $widget);

		let rndId = `lander-widget-form-privacy-checkbox-${Math.random()}`;

		$widget__checkbox.attr('id', rndId);
		$widget__label
			.attr('for', rndId)
			.html(this.currentLanguage.widgetFormPrivacyLabel);

		$form.append($widget);

		return this;

	}

	/**
	 * Устанавливается прослушка на чекбок.
	 * Кнопка отправка формы делается активной/неактивной
	 * @return {Lander} [description]
	 */
	private initFormPrivacyListener():Lander{

		$(document).on('lander:init-privacy-check change', 'input[name="personalDataAgree"]', (ev:any)=>{

			let $checkbox = $(ev.currentTarget);

			let $form = $checkbox.closest('form');

			let $btn = $('button, input[type="submit"]', $form);

			let checked:boolean[] = [];

			$checkbox.each((index:number, $el:any)=>{

				checked.push($el.checked);

			});

			if ( checked.indexOf(false) == -1 ) {

				$btn.removeAttr('disabled');

			}
			else {

				$btn.attr('disabled', 'disabled');

			}

		});

		$('input[name="personalDataAgree"]').trigger('lander:init-privacy-check');

		return this;

	}

	/**
	 * сбор всех данных для отправки в лендер или хелперов
	 * @param  {any}   $form [description]
	 * @return {any[]}       [description]
	 */
	getAjaxData($form:any):any[]{

		let action = $form.attr('action');

		if(!action){

			action = this.params.action;

		} else {

			action = action.replace(/&amp;/g, '&');

		}

		let formData:assoc[] = $form.serializeArray();
		let formDataParsed:assoc = {};

		for(let i = 0; i < formData.length; i++){

			formDataParsed[formData[i].name] = formData[i].value;

		}

		let generateData:assoc = this.generateData();
		let actionData:assoc = url('?', action);
		let urlData:assoc = this.url;
		let cookieData = cookie.all();

		let result:any[] = [action,formData,formDataParsed,generateData,actionData,urlData,cookieData];

		return result;

	}

	/**
	 * автоматическая отправка формы при focusout на synergy и synergyonline
	 * @return {Lander} [description]
	 */
	private initAutoSubmit():Lander{

		if(/synergy.ru|synergyonline.ru|examples/i.test(window.location.hostname)){ // TODO: examples - dev версия

			$(document).on('focusout', 'form.lander-inited', (ev:any)=>{

				ev.preventDefault();

				let $form = $(ev.currentTarget);

				let $emailInput = $('input[name="email"]', $form);

				if( !this.validateEmail($emailInput.val(), $emailInput) ) return;

				if( !$form.data('lander-auto-submit-block') ){

					$form.data('lander-auto-submit-block', true);

					let [
						action,
						formData,
						formDataParsed,
						generateData,
						actionData,
						urlData,
						cookieData
					]:any = this.getAjaxData($form);

					let fullData:assoc = this.extendData(urlData, actionData, cookieData, generateData, formDataParsed);

					fullData.r = 'dump';

					// TODO: разобраться с параметром r, и ваще...
					$.ajax({

						url: 'https://syn.su/v3/?r=dump',
						method: 'POST',
						data: fullData,
						dataType: 'JSON',
						success: function(data:any){

							console.log(data);

							$form.data('lander-auto-submit-block', false);

						}

					});

				} else return;

			})

		}

		return this;

	}

	/**
	 * По ctrl+click по форме будет показываться системная информация
	 * @return {Lander} [description]
	 */
	private initFormHelper():Lander{

		$(document).on('click', 'form.lander-inited', (ev:any)=>{

			if(!ev.ctrlKey && !ev.cmdKey && !ev.metaKey) return;

			let $form = $(ev.currentTarget);

			let [
				action,
				formData,
				formDataParsed,
				generateData,
				actionData,
				urlData,
				cookieData
			]:any = this.getAjaxData($form);

			let dataset:assoc = [

				{
					name: 'Поля формы',
					data: formDataParsed
				},
				{
					name: 'Сгенерированые данные',
					data: generateData
				},
				{
					name: 'Action формы',
					data: actionData
				},
				{
					name: 'URL',
					data: urlData
				},
				{
					name: 'Cookies',
					data: cookieData
				}

			];

			let fullData:assoc = this.extendData(urlData, actionData, {}, generateData, formDataParsed);

			dataset.unshift({

				name: 'Что уйдет в лендер',
				data: fullData

			});

			let $widget = $(this.widgets.formInfo);

			let widgetClassName = $widget.attr('class');

			for(let i = 0; i < dataset.length; i++ ){

				let data = dataset[i];

				$widget.append(`
					<tr>
						<th colspan=2>
							${data.name}
						</th>
					</tr>`
				);

				for(let i in data.data){

					if(!data.data.hasOwnProperty(i)) continue;

					$widget.append(`
						<tr>
							<td>
								${i}
							</td>
							<td>
								${data.data[i]}
							</td>
						</tr>`
					);

				}

			}

			$.fancybox( $widget );

		});

		return this;

	}

	/**
	 * Отправка формы
	 * Собираются все данные из куки, url, localstorage, инпутов и отправляются на сервер
	 * Отправляется событие в GA
	 * Обрабатывается ответ от лендера TODO вынести в отдельный метод
	 * @return {Lander} [description]
	 */
	private initFormSubmit():Lander{

		$(document).on('submit', 'form.lander-inited', (ev:any)=>{

			let $form = $(ev.target);

			let [
				action,
				formData,
				formDataParsed,
				generateData,
				actionData,
				urlData,
				cookieData
			]:any = this.getAjaxData($form);

			let validateErrors:any[];

			validateErrors = this.validateForm($form);

			let $submitButton:any = $('[type="submit"],button', $form);

			if($submitButton.attr('disabled')) return false;

			if(validateErrors.length){

				for(let i = 0; i < validateErrors.length; i++){

					this.setInvalidInput(validateErrors[i]);

				}

				validateErrors[0].$input.focus();

				return false;

			}

			let fullData:assoc = this.extendData(urlData, actionData, cookieData, generateData, formDataParsed);

			this.saveUser(fullData.name, fullData.phone, fullData.email);

			// собираем массив для пуша в GA			
			let gaPush:assoc[] = [];

			for(let prop in fullData){

				if(!fullData.hasOwnProperty(prop)) continue;

				let newPush:assoc = {};
				newPush[`gtm.element.dataset.${prop}`] = fullData[prop];

				gaPush.push(newPush);

			};
			gaPush.push({'gtm.element.dataset.phone_md5': md5(fullData.phone)});
			gaPush.push({'gtm.element.dataset.email_md5': md5(fullData.email)});

			this.ga.push(...gaPush);

			// оставлю на случай быстрого реагирования
			/*this.ga.push(
				{'gtm.element.dataset.guid': fullData.guid},
				{'gtm.element.dataset.landname': fullData.landname},
				{'gtm.element.dataset.version': fullData.version},
				{'gtm.element.dataset.form': fullData.form},
				{'gtm.element.dataset.phone': fullData.phone},
				{'gtm.element.dataset.phone_md5': md5(fullData.phone)},
				{'gtm.element.dataset.email': fullData.email},
				{'gtm.element.dataset.email_md5': md5(fullData.email)},
				{'gtm.element.dataset.cost': fullData.cost || fullData.price},
				{'gtm.element.dataset.partner': fullData.partner},
				{'gtm.element.dataset.land': fullData.land},
				{'gtm.element.dataset.speaker': fullData.speaker},
				{'gtm.element.dataset.program': fullData.program},
				{'gtm.element.dataset.dater': fullData.dater},
				{'gtm.element.dataset.type': fullData.type},
				{'gtm.element.dataset.link': fullData.link}
			);*/

			this.setFormLoading($form);

			$.ajax({

				url: action,
				method: 'POST',
				data: fullData,
				success: (data:any)=>{

					this.submitSuccess(data, $form);

				}

			});

			return false;

		});

		return this;

	}

	/**
	 * обработчик ответа от бэкенда
	 * @param {any} data  [description]
	 * @param {any} $form [description]
	 */
	private submitSuccess(data:any, $form:any):void{

		this.ga.push({'event': 'gtm.formSubmit'});

		let response:any;
		let responseIsJson = false;

		try{

			response = $(data);

		} catch(err) {

			try{

				response = JSON.stringify(data);
				responseIsJson = true;

			} catch(err) {

				response = `<div>${data}</div>`;
				responseIsJson = false;

			}

		}

		if(!responseIsJson){

			this.unsetFormLoading($form);

			// пришла капча
			if( $('.lander-capcha', $form).length ){

				alert('TODO: CAPCHA');

			} 
			// пришла смс-верификация
			else if( $('.lander-sms', $form).length ){

				alert('TODO: SMS');

			}
			// обычный ответ
			else {

				$form.empty().html(response);

			}

		} else {

			alert('TODO: JSON');

			/*
				TODO: если в ответ пришел JSON, с Лёхой договоримся че тут делать с ним
			 */

		}

		$(window).trigger('lander-send-success');
		$form.trigger('lander-send-success');

	}

	/**
	 * В зависимости от домена приоритет у разных источников данных разный
	 * @param  {assoc} urlData      [description]
	 * @param  {assoc} actionData   [description]
	 * @param  {assoc} cookieData   [description]
	 * @param  {assoc} generateData [description]
	 * @param  {assoc} formData     [description]
	 * @return {assoc}              [description]
	 */
	extendData(urlData:assoc, actionData:assoc, cookieData:assoc, generateData:assoc, formData:assoc):assoc{

		let result:assoc = {};

		switch (window.location.hostname) {
			
			// url <- action <- cookie <- generateData <- formData
			case 'synergyregions.ru':
			case 'sbs.edu.ru':

				$.extend(true, result, urlData, actionData, cookieData, generateData, formData);

			break;
			// дефолтный порядок:
			// cookie <- action <- url <- generateData <- formData
			case 'synergy.ru':
			case 'synergyonline.ru':

				$.extend(true, result, cookieData, urlData, actionData, generateData, formData);

			break;
			default: 

				$.extend(true, result, cookieData, urlData, actionData, generateData, formData);

			break;

		}

		return result;

	}

	/**
	 * Установка каких-то кук для каки-то доменов
	 * @return {Lander} [description]
	 */
	private setDomainCookies():Lander{

		let domain:string = window.location.hostname;

		/* Сохранение partner в куки для synergyregions и synergyglobal */
		if(/synergyregions.ru|synergyglobal.ru/.test(domain)){

			// для synergyglobal кука установится на сессию
			let exp:number = 0;
			let cookieName:string = 'GlobalPartner';

			// для synergyregions кука установится на 3 года
			if(domain == 'synergyregions.ru'){

				exp = 3;
				cookieName = 'SynergyPartner';

			}

			let expires:string;
			let D:any = new Date();

			D.setFullYear(D.getFullYear() + exp);
			expires = D.toGMTString();

			let cookieSet:assoc = {}
			cookieSet[cookieName] = this.url.partner;

			cookie.set(cookieSet, {

				path: '/',
				expires: expires

			});

		}

		// Сохранение utm-меток в куки для synergy и synergyonline и еще всякого
		if(/synergy\.ru|synergyonline\.ru|synergyglobal\.ru|synergy\.mba|sbs\.edu\.ru|mosap\.ru|xn\-\-80aayoegldhg0a2a2j\.xn\-\-p1ai/.test(domain)){

			let cookies:assoc = {};
			let cookiesAll:assoc = cookie.all();

			if(!cookiesAll.utm_source && this.url.utm_source) cookies.utm_source = this.url.utm_source;
			if(!cookiesAll.utm_medium && this.url.utm_medium) cookies.utm_medium = this.url.utm_medium;
			if(!cookiesAll.utm_campaign && this.url.utm_campaign) cookies.utm_campaign = this.url.utm_campaign;
			if(!cookiesAll.utm_content && this.url.utm_content) cookies.utm_content = this.url.utm_content;
			if(!cookiesAll.utm_term && this.url.utm_term) cookies.utm_term = this.url.utm_term;

			cookie.set(cookies, {
				path: '/'
			});

		}

		return this;

	}

	/**
	 * Сохраняет форму в localStorage
	 * @param  {string} name  [description]
	 * @param  {string} phone [description]
	 * @param  {string} email [description]
	 * @return {Lander}       [description]
	 */
	private saveUser(name:string, phone:string, email:string):Lander{

		if(!this.checkLocalStorage()) return this;

		if(name) localStorage.setItem('name', name);
		if(phone) localStorage.setItem('phone', phone);
		if(email) localStorage.setItem('email', email);

		return this;

	}

	/**
	 * Генерация и модификация данных для отправки в лендер
	 * @return {assoc} [description]
	 */
	private generateData():assoc{

		let guid = 'id_' + Math.random().toString(36).substr(2, 9);
		let mergelead = guid + Date.now();

		let cookieData = cookie.all();

		let piwikId:string|null = null;

		for(let cookie in cookieData){

			if( /_pk_id/i.test(cookie) ){

				piwikId = cookieData[cookie];
				break;

			}

		}

		return {
			guid, 
			mergelead, 
			lang: this.lang,
			refer: document.referrer,

			// всякие аналитики, хз зачем, итак в куках уходят
			// решили оставить чтобы бэкенд смотрел только в POST
			piwik_id: piwikId,
			PAPVisitorId: cookieData.PAPVisitorId || null,
			roistat_visit: cookieData.roistat_visit || null,
			analytics_id: cookieData._ga || null
		};

	}

	/**
	 * Блокировка формы во время отправки
	 * @param  {any}    $form [description]
	 * @return {Lander}       [description]
	 */
	setFormLoading($form:any):Lander{

		$('input:not([disabled="disabled"]), textarea:not([disabled="disabled"]), select:not([disabled="disabled"])', $form)
			.attr({
				'data-lander-input-disabled': "disabled",
				'disabled': true
			});

		$form.addClass('lander-form-sending');

		$('[type="submit"]', $form)
			.addClass('lander-form-submit-sending')
			.data('lander-value', $('[type="submit"]', $form).val())
			.val(this.currentLanguage.sending);
		$('button', $form)
			.addClass('lander-form-submit-sending')
			.data('lander-value', $('button', $form).html())
			.html(this.currentLanguage.sending);

		return this;

	}

	/**
	 * Разблокировка формы после отправки
	 * @param {any} $form [description]
	 * @return {Lander}       [description]
	 */
	unsetFormLoading($form:any):Lander{

		$('input:not([data-lander-input-disabled!="disabled"]), textarea:not([data-lander-input-disabled!="disabled"]), select:not([data-lander-input-disabled!="disabled"])', $form).attr('disabled', false);

		$form.removeClass('lander-form-sending');

		$('[type="submit"]', $form)
			.removeClass('lander-form-submit-sending')
			.val( $('[type="submit"]', $form).data('lander-value') );
		$('button', $form)
			.removeClass('lander-form-submit-sending')
			.html( $('button', $form).data('lander-value') );

		return this;

	}

	/**
	 * Валидация уже ошибочного инпута при каждом изменении
	 * @return {Lander} [description]
	 */
	private validateFormListener():Lander{

		$(document).on('change input focus', 
			'input.lander-invalid-input-error, \
			textarea.lander-invalid-input-error, \
			select.lander-invalid-input-error', (ev:any)=>{

			let $el = $(ev.currentTarget).closest('form');

			let validateErrors:any[];

			validateErrors = this.validateForm($el);
			if(validateErrors.length){

				for(let i = 0; i < validateErrors.length; i++){

					this.setInvalidInput(validateErrors[i]);

				}

			}

		});

		return this;

	}

	/**
	 * Валидация формы
	 * @param  {any}   $form [description]
	 * @return {any[]}       Возвращает массив ошибок
	 */
	validateForm($form:any):any[]{

		let errors:any[] = [];

		$('input, textarea, select', $form).each((index:number, input:any)=>{

			let $input = $(input);

			let name:string = $input.attr('name');
			let mask:string = $input.data('lander-validate-mask');
			let required:boolean = !!$input.attr('required');
			let value:string|boolean = $input.val() || !!$input.checked;

			let err:assoc = {$input: $input, errorMessage: false};

			if(required && !value){

				err.errorMessage = this.currentLanguage.requiredField

			} else {

				switch(name){

					case 'name':

						if(!this.validateName(value, $input)){

							err.errorMessage = this.currentLanguage.invalidName

						}

					break;
					case 'phone':

						if(!this.validatePhone(value, $input)){

							err.errorMessage = this.currentLanguage.invalidPhone

						}

					break;
					case 'email':

						if(!this.validateEmail(value, $input)){

							err.errorMessage = this.currentLanguage.invalidEmail

						}

					break;
					default: 

						if(mask && !this.validateMask(value, mask, $input)){

							err.errorMessage = this.currentLanguage.invalidMask

						}

					break;

				}

			}

			if(err.errorMessage !== false){

				errors.push(err);

			} else {

				this.setValidInput($input);

			}

		});

		return errors;

	}

	/**
	 * Валидация имени
	 * @param {string|boolean} val    [description]
	 * @param {any}            $input [description]
	 * @return {boolean}               [description]
	 */
	validateName(val:string|boolean, $input:any):boolean{

		if(typeof val == 'boolean') return false;
		if(this.lang == 'cn') return true;

		let reg:RegExp = /^[\wа-яёJł∫łÅÃǺǻаάẫẮắẰằẴẵÄĄªäÅÄÀÁÂåãâàάâáàÂâãΆลฉสαจЂδßβҐґŗѓΔ∂ðgġℊΣĒēĔĕĖėĘЁеěĚęΈëêξÊÈξ€Єèé€ËÉ∑∑ẾЕỀỂỄєﻉeЄєέεℯзʒυนմuหųůύϋΰÙúÚΰùÛûửữüừŨũŪūŬŭűŮK∫รI{kใรlรκIร)รķเรǨќķĶЌJlJเ∫lΛλภJI∫५ณmრฬʍ₥றभҢทฑηήnñµņңňĤĦΉŀlΉЊℋØøอσőǾŌΘŏōฮθทฑnГlթþקρÞζçÇ¢çςČċĊĉςĈćĆċčॡТדŦŤ†TτΐŢყע¥γЎұצφאхχ×ჯԱųŲҹԿ५ώωա๒ьIзЭәӘศ \-\'\`]{2,100}$/i;

		return reg.test(val);

	}

	/**
	 * Валидация телефона
	 * @param {string|boolean} val    [description]
	 * @param {any}            $input [description]
	 * @return {boolean}               [description]
	 */
	validatePhone(val:string|boolean, $input:any):boolean{

		if(typeof val == 'boolean') return false;

		if($input && $input.data('lander-inputmask-inited')){

			return $input.inputmask('isComplete');

		} else {

			let reg:RegExp = /^[0-9\- \(\)]{5,20}/i;

			return reg.test(val);

		}

	}

	/**
	 * Валидация почты
	 * @param {string|boolean} val    [description]
	 * @param {any}            $input [description]
	 * @return {boolean}               [description]
	 */
	validateEmail(val:string|boolean, $input:any):boolean{

		if(typeof val == 'boolean') return false;

		let reg:RegExp = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

		return reg.test(val);

	}

	/**
	 * Валидация по произвольному выражению
	 * @param  {string|boolean} val    [description]
	 * @param  {string}         mask   [description]
	 * @param  {any}            $input [description]
	 * @return {boolean}               [description]
	 */
	validateMask(val:string|boolean, mask:string, $input:any):boolean{

		if(typeof val == 'boolean') return false;

		let reg:RegExp = new RegExp(mask, 'i');

		return reg.test(val);

	}

	/**
	 * Установка состояния ошибки для инпута
	 * Добавляется класс lander-invalid-input-error и label с описанием ошибки
	 * @param {assoc} data [description]
	 * @return {Lander}       [description]
	 */
	setInvalidInput(data:assoc):Lander{

		let $input = data.$input;

		$input.addClass('lander-invalid-input-error');

		// если инпут это чекбокс - то не добавляем ему лэйбл с ошибкой
		if($input.attr('type') == 'checkbox') return this;

		//let $inputParent = $input.parent();
		let $labelForInput = $input.next();

		if( $labelForInput.hasClass('lander-invalid-input-error-label') ){

			$labelForInput.html(data.errorMessage);

		} else {

			$input.after(`<label class="lander-invalid-input-error-label">${data.errorMessage}</label>`);

		}

		return this;

	}

	/**
	 * TODO: task 182269
	 */

	/**
	 * Удаление состояния ошибки для инпута
	 * Удаляется класс lander-invalid-input-error и label с описанием ошибки
	 * @param {assoc} data [description]
	 * @return {Lander}       [description]
	 */
	setValidInput($input:any):Lander{

		$input
			.removeClass('lander-invalid-input-error')
			.addClass('lander-valid-input');

		// если инпут это чекбокс - то не добавляем ему лэйбл с ошибкой
		if($input.attr('type') == 'checkbox') return this;

		//let $inputParent = $input.parent();
		let $labelForInput = $input.next();

		if( $labelForInput.hasClass('lander-invalid-input-error-label') ){

			$labelForInput.remove();

		}

		return this;

	}

	/**
	 * Сохранение параметров из url
	 * @return {assoc} [description]
	 */
	private initUrl():assoc{

		this.url = url('?') || {};
		return this.url;

	}

	/**
	 * Инициализация данных юзера из кук и localstorage
	 * @return {assoc} [description]
	 */
	private initUser():assoc{

		let allCookie:any = cookie.all();

		let userCookie:assoc = {

			name: allCookie.name,
			phone: allCookie.phone,
			email: allCookie.email,

		}

		let userLocalStorage:assoc = this.getLocalStorage(['name', 'phone', 'email']);

		this.user = $.extend(true, userCookie, userLocalStorage);

		return this.user;

	}

	/**
	 * Сериализация LocalStorage
	 * @param  {string[] = []}          fields [description]
	 * @return {assoc}         [description]
	 */
	getLocalStorage(fields:string[] = []):assoc{

		let result:assoc = {};

		if(this.checkLocalStorage()){

			if(fields.length){

				result = JSON.parse( JSON.stringify(localStorage, fields) );
				
			} else {

				result = JSON.parse( JSON.stringify(localStorage) );

			}

		}

		return result;

	}

	/**
	 * Проверка доступности localStorage
	 * @return {boolean} [description]
	 */
	checkLocalStorage():boolean{

		try{

			if(typeof localStorage == 'object'){

				if(typeof localStorage.setItem == 'function' && typeof localStorage.getItem == 'function'){

					return true;

				}

			}

		} catch(err) { 

			return false; 

		}

		return false;

	}

	/**
	 * Получить какое-то свойство юзера или пустую строку
	 * @param  {string} prop [description]
	 * @return {any}         [description]
	 */
	getUserProp(prop:string):any{

		return this.user[prop] || '';

	}

	/**
	 * Инициализация ссылок с политикой конфиденциальности
	 * Прослушка навешивается на [href="#privacy"]
	 * @return {Lander} [description]
	 */
	initPrivacyLinks():Lander{

		$(document).on('click', '[href="#privacy"]', (ev:any)=>{

			let url = `http://synergy.ru/lp/_chunk/privacy.php?lang=${this.lang}&date=${Date.now()}`;

			$.fancybox({
				href: url,
				type: 'ajax',
				maxWidth: 910,
				autoResize: true,
				padding: 0,
				wrapCSS: 'lander-widget-privacy',
				helpers: {
					overlay: {
						locked: false
					}
				}
			});

			return false;

		});

		return this;

	}

	/**
	 * Определение региона пользователя по IP
	 * @return {Lander} [description]
	 */
	checkRegion():Lander{

		return this;

	}

	/**
	 * фичи для разработчиков: сетка, изменение параметров форм...
	 * @return {Lander} [description]
	 */
	private initDevTools():Lander{

		return this;

	}

	/**
	 * Получить язык страницы
	 * @return {string} [description]
	 */
	getDocumentLanguage():string{

		let lang:string = document.documentElement.lang || 'ru';

		return lang;

	}

	/**
	 * Установка языка лендера, для подстановки фраз на нужном языке
	 * @param  {string} lang [description]
	 * @return {assoc}       [description]
	 */
	setLanderLang(lang:string = 'ru'):assoc|boolean{

		if(this.dictionary[lang]){

			this.currentLanguage = this.dictionary[lang];
			return this.currentLanguage;

		} else {

			console.error(`В словаре лендера нет языка ${lang}`);
			return false;

		}

	}

	/**
	 * Загрузка ресурсов
	 * @param {assoc[]}    depedences [description]
	 * @param {boolean =          false}       addRand [description]
	 */
	loadResources(depedences:assoc[], addRand:boolean = false):void{

		let that:Lander = this;

		for(let i = 0; i < depedences.length; i++){

			let resource = depedences[i];

			// если у загружаемого ресурса нет потомков, грузим со своим колбэком
			if(Array.isArray(resource.childrens) && !resource.childrens.length){

				// загружается соответствующий ресурс, после загрузки вызывается колбэк, если есть
				this.loadExternal({
					name: resource.name,
					url: resource.url,
					addRand: addRand,
					full: resource
				}, ()=>{

					resource.loaded = true;
					this.resourceLoaded(resource.name);

				});

			} else {

				// загружается соответствующий ресурс, после загрузки начинают загружаться потомки
				this.loadExternal({
					name: resource.name,
					url: resource.url,
					addRand: addRand,
					full: resource
				}, ()=>{

					resource.loaded = true;
					this.resourceLoaded(resource.name);

					this.loadResources(resource.childrens, addRand);
				
				});

			}

		}

	}

	/**
	 * Поиск обязательных ресурсов
	 * @param  {assoc[]}  resources [description]
	 * @return {string[]}           [description]
	 */
	private resourcesMap(resources:assoc[]):string[]{

		for(let i = 0; i < resources.length; i++){

			let resource = resources[i];

			if(Array.isArray(resource.childrens)){

				if(!resource.childrens.length && resource.required){

					this.requiredResources.push(resource.name);

				} else if(resource.childrens.length) {

					if(resource.required){

						this.requiredResources.push(resource.name);

					}

					this.resourcesMap(resource.childrens);

				}

			} 

		}

		return this.requiredResources;

	}

	/**
	 * Как только все обязательные ресурсы загружены, вызывается start()
	 * @param  {string} name [description]
	 * @return {Lander}      [description]
	 */
	private resourceLoaded(name:string):Lander{

		let index:number = this.requiredResources.indexOf(name);

		if(index !== -1){

			this.requiredResources.splice(index, 1);

		}

		// все ресурсы загружены, можно стартовать лендер
		if(this.requiredResources.length == 0){

			this.start();

		}

		return this;

	}

	/**
	 * Загрузка ресурса
	 * @param  {name:string, url:string, addRand:boolean}	params    [description]
	 * @param  {any}       callback функция колбэк будет выполнена после загрузки
	 * @return {any}                [description]
	 */
	loadExternal(params:{name:string, url:string, addRand:boolean, full:assoc}, callback?:any):any{

		if(typeof params.full.afterLoad == 'function'){

			params.full.afterLoad();						

		}

		if(params.full.check){

			callback();
			return;

		}

		let {name, url, addRand} = params;

		// берем расширение файла из url
		let type:string = url.split('.').slice(-1)[0];

		if(addRand){

			url += '?nocache=' + Math.random();

		};

		let newResource:any;

		switch (type) {

			case 'js':

				newResource = document.createElement('script');
				newResource.setAttribute('src', url);
				newResource.setAttribute('type', 'text/javascript');

			break;
			case 'css':

				newResource = document.createElement('link');
				newResource.setAttribute('href', url);
				newResource.setAttribute('rel', 'stylesheet');

			break;

		}

		document.body.appendChild(newResource);

		if(typeof callback == 'function'){

			newResource.onload = function(...args:any[]){ 

				if(!this.executed){

					this.executed = true;
					callback('onload', ...args ); 
					
				}

			};
			newResource.onerror = function(...args:any[]){ 

				if(!this.executed){

					this.executed = true;
					callback('onerror', ...args ); 
					
				}

			};
			newResource.onreadystatechange = function(){

				if(this.readyState == 'complete' || this.readyState == 'loaded'){

					setTimeout(()=>{ this.onload(); }, 0);

				}

			}

		}

	}

}

document.addEventListener("DOMContentLoaded", function(){

	(<any>window).LANDER = new Lander((<any>window).dataLayer);
	
});


}