"use strict";
var LANDER;
(function (LANDER) {
    (function () {
        if (![].forEach || !window.addEventListener) {
            window.location.href = "http://lander3/public/front/pages/badbrowser.php";
        }
    })();
    (function () {
        var gtm = document.createElement('script');
        gtm.src = 'http://lander3/public/front/js/gtm.min.js';
        console.log(Date.now());
        document.head.appendChild(gtm);
    })();
    var Lander = (function () {
        function Lander(ga) {
            if (ga === void 0) { ga = []; }
            console.log(Date.now());
            this.ga = ga;
            this.setLanderParams();
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
            this.depedences = [
                {
                    name: 'jQuery',
                    url: 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',
                    required: true,
                    check: typeof window.jQuery == 'function',
                    afterLoad: function () {
                    },
                    childrens: [
                        {
                            name: 'inputmask',
                            url: 'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js',
                            required: true,
                            check: typeof window.jQuery == 'function' && $.fn.inputmask,
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
                                    url: 'https://syn.su/js/phone-addon.js',
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
                            check: typeof window.jQuery == 'function' && window.jQuery.fn.fancybox,
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
                    check: window.url,
                    childrens: [],
                    loaded: false,
                },
                {
                    name: 'cookie',
                    url: 'https://cdnjs.cloudflare.com/ajax/libs/cookie.js/1.2.2/cookie.min.js',
                    required: true,
                    check: window.cookie,
                    childrens: [],
                    loaded: false,
                },
                {
                    name: 'md5',
                    url: 'https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.8.0/js/md5.min.js',
                    required: true,
                    check: window.md5,
                    childrens: [],
                    loaded: false,
                },
                {
                    name: 'fancyboxCss',
                    url: 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/css/jquery.fancybox.min.css',
                    childrens: [],
                    check: typeof window.jQuery == 'function' && window.jQuery.fn.fancybox,
                    loaded: false,
                },
                {
                    name: 'landerCss',
                    url: this.params.baseUrl + "/css/lander.css",
                    childrens: [],
                    loaded: false,
                }
            ];
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
            };
            this.lang = this.getDocumentLanguage();
            this.setLanderLang(this.lang);
            this.requiredResources = [];
            this.resourcesMap(this.depedences);
            this.loadResources(this.depedences);
        }
        Lander.prototype.setLanderParams = function () {
            var scriptTag = document.querySelector('script[src*="lander"]');
            var paramsArr = scriptTag.dataset.landerOptions.split(',');
            var params = [];
            for (var i = 0; i < paramsArr.length; i++) {
                if (!paramsArr[i])
                    continue;
                var split = paramsArr[i].split('=');
                params[split[0]] = split[1];
            }
            this.params = {
                action: params.action || 'https://syn.su/lander.php',
                dev: params.dev || false,
                baseUrl: params.baseUrl || 'https://syn.su'
            };
            return this.params;
        };
        Lander.prototype.start = function () {
            if (this.inited)
                return this;
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
                .initUtils();
            if (this.params.dev) {
                this.initDevTools();
            }
            this.initAutoSubmit();
            this.inited = true;
            return this;
        };
        Lander.prototype.initUtils = function () {
            this
                .initDefaultFancybox()
                .initDefaultScroll();
            return this;
        };
        Lander.prototype.initDefaultFancybox = function () {
            $(document).on('click', '.lander-fancybox', function (ev) {
                var $el = $(ev.currentTarget);
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
            });
            return this;
        };
        Lander.prototype.initDefaultScroll = function () {
            $(document).on('click', '.lander-scroll', function (ev) {
                var $el = $(ev.currentTarget);
                var $target = $($el.attr('href'));
                if (!$target.length)
                    return;
                var posTop = $target.offset().top;
                $('html, body').animate({ scrollTop: posTop }, 1000);
                return false;
            });
            return this;
        };
        Lander.prototype.initForms = function ($context) {
            var _this = this;
            if ($context === void 0) { $context = $(document); }
            var $forms = $('form:not(.lander-off):not(.lander-inited)', $context);
            $forms.each(function (index, el) {
                var $form = $(el);
                _this.initFormInputs($form);
                if (/synergy.ru|synergyonline.ru|examples/i.test(window.location.hostname)) {
                    _this.initFormPrivacy($form);
                }
                $form.addClass('lander-inited');
            });
            return this;
        };
        Lander.prototype.initFormInputs = function ($form) {
            var $name = $('[name="name"]', $form);
            var $phone = $('[name="phone"]', $form);
            var $email = $('[name="email"]', $form);
            $phone
                .filter(':not(data-lander-inputmask-inited)')
                .attr('type', 'text')
                .inputmask({ alias: 'phone' })
                .attr('data-lander-inputmask-inited', true);
            $name.val(this.getUserProp('name'));
            $phone.val(this.getUserProp('phone'));
            $email.val(this.getUserProp('email'));
            return this;
        };
        Lander.prototype.initFormPrivacy = function ($form) {
            $form = $form.filter(':not(.lander-privacy-off):not(.lander-privacy-inited)');
            var $currentWidgets = $('[name="personalDataAgree"]', $form);
            if ($form.length < 1 || $currentWidgets.length > 0) {
                return this;
            }
            var $widget = $(this.widgets.formPrivacy);
            var $widget__checkbox = $('.lander-widget-form-privacy__checkbox', $widget);
            var $widget__label = $('.lander-widget-form-privacy__label', $widget);
            var rndId = "lander-widget-form-privacy-checkbox-" + Math.random();
            $widget__checkbox.attr('id', rndId);
            $widget__label
                .attr('for', rndId)
                .html(this.currentLanguage.widgetFormPrivacyLabel);
            $form.append($widget);
            return this;
        };
        Lander.prototype.initFormPrivacyListener = function () {
            $(document).on('lander:init-privacy-check change', 'input[name="personalDataAgree"]', function (ev) {
                var $checkbox = $(ev.currentTarget);
                var $form = $checkbox.closest('form');
                var $btn = $('button, input[type="submit"]', $form);
                var checked = [];
                $checkbox.each(function (index, $el) {
                    checked.push($el.checked);
                });
                if (checked.indexOf(false) == -1) {
                    $btn.removeAttr('disabled');
                }
                else {
                    $btn.attr('disabled', 'disabled');
                }
            });
            $('input[name="personalDataAgree"]').trigger('lander:init-privacy-check');
            return this;
        };
        Lander.prototype.getAjaxData = function ($form) {
            var action = $form.attr('action');
            if (!action) {
                action = this.params.action;
            }
            else {
                action = action.replace(/&amp;/g, '&');
            }
            var formData = $form.serializeArray();
            var formDataParsed = {};
            for (var i = 0; i < formData.length; i++) {
                formDataParsed[formData[i].name] = formData[i].value;
            }
            var generateData = this.generateData();
            var actionData = url('?', action);
            var urlData = this.url;
            var cookieData = cookie.all();
            var result = [action, formData, formDataParsed, generateData, actionData, urlData, cookieData];
            return result;
        };
        Lander.prototype.initAutoSubmit = function () {
            var _this = this;
            if (/synergy.ru|synergyonline.ru|examples/i.test(window.location.hostname)) {
                $(document).on('focusout', 'form.lander-inited', function (ev) {
                    ev.preventDefault();
                    var $form = $(ev.currentTarget);
                    var $emailInput = $('input[name="email"]', $form);
                    if (!_this.validateEmail($emailInput.val(), $emailInput))
                        return;
                    if (!$form.data('lander-auto-submit-block')) {
                        $form.data('lander-auto-submit-block', true);
                        var _a = _this.getAjaxData($form), action = _a[0], formData = _a[1], formDataParsed = _a[2], generateData = _a[3], actionData = _a[4], urlData = _a[5], cookieData = _a[6];
                        var fullData = _this.extendData(urlData, actionData, cookieData, generateData, formDataParsed);
                        fullData.r = 'dump';
                        $.ajax({
                            url: 'https://syn.su/v3/?r=dump',
                            method: 'POST',
                            data: fullData,
                            dataType: 'JSON',
                            success: function (data) {
                                console.log(data);
                                $form.data('lander-auto-submit-block', false);
                            }
                        });
                    }
                    else
                        return;
                });
            }
            return this;
        };
        Lander.prototype.initFormHelper = function () {
            var _this = this;
            $(document).on('click', 'form.lander-inited', function (ev) {
                if (!ev.ctrlKey && !ev.cmdKey && !ev.metaKey)
                    return;
                var $form = $(ev.currentTarget);
                var _a = _this.getAjaxData($form), action = _a[0], formData = _a[1], formDataParsed = _a[2], generateData = _a[3], actionData = _a[4], urlData = _a[5], cookieData = _a[6];
                var dataset = [
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
                var fullData = _this.extendData(urlData, actionData, {}, generateData, formDataParsed);
                dataset.unshift({
                    name: 'Что уйдет в лендер',
                    data: fullData
                });
                var $widget = $(_this.widgets.formInfo);
                var widgetClassName = $widget.attr('class');
                for (var i = 0; i < dataset.length; i++) {
                    var data = dataset[i];
                    $widget.append("\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<th colspan=2>\n\t\t\t\t\t\t\t" + data.name + "\n\t\t\t\t\t\t</th>\n\t\t\t\t\t</tr>");
                    for (var i_1 in data.data) {
                        if (!data.data.hasOwnProperty(i_1))
                            continue;
                        $widget.append("\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" + i_1 + "\n\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" + data.data[i_1] + "\n\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t</tr>");
                    }
                }
                $.fancybox($widget);
            });
            return this;
        };
        Lander.prototype.initFormSubmit = function () {
            var _this = this;
            $(document).on('submit', 'form.lander-inited', function (ev) {
                var $form = $(ev.target);
                var _a = _this.getAjaxData($form), action = _a[0], formData = _a[1], formDataParsed = _a[2], generateData = _a[3], actionData = _a[4], urlData = _a[5], cookieData = _a[6];
                var validateErrors;
                validateErrors = _this.validateForm($form);
                var $submitButton = $('[type="submit"],button', $form);
                if ($submitButton.attr('disabled'))
                    return false;
                if (validateErrors.length) {
                    for (var i = 0; i < validateErrors.length; i++) {
                        _this.setInvalidInput(validateErrors[i]);
                    }
                    validateErrors[0].$input.focus();
                    return false;
                }
                var fullData = _this.extendData(urlData, actionData, cookieData, generateData, formDataParsed);
                _this.saveUser(fullData.name, fullData.phone, fullData.email);
                var gaPush = [];
                for (var prop in fullData) {
                    if (!fullData.hasOwnProperty(prop))
                        continue;
                    var newPush = {};
                    newPush["gtm.element.dataset." + prop] = fullData[prop];
                    gaPush.push(newPush);
                }
                ;
                gaPush.push({ 'gtm.element.dataset.phone_md5': md5(fullData.phone) });
                gaPush.push({ 'gtm.element.dataset.email_md5': md5(fullData.email) });
                (_b = _this.ga).push.apply(_b, gaPush);
                _this.setFormLoading($form);
                $.ajax({
                    url: action,
                    method: 'POST',
                    data: fullData,
                    success: function (data) {
                        _this.submitSuccess(data, $form);
                    }
                });
                return false;
                var _b;
            });
            return this;
        };
        Lander.prototype.submitSuccess = function (data, $form) {
            this.ga.push({ 'event': 'gtm.formSubmit' });
            var response;
            var responseIsJson = false;
            try {
                response = $(data);
            }
            catch (err) {
                try {
                    response = JSON.stringify(data);
                    responseIsJson = true;
                }
                catch (err) {
                    response = "<div>" + data + "</div>";
                    responseIsJson = false;
                }
            }
            if (!responseIsJson) {
                this.unsetFormLoading($form);
                if ($('.lander-capcha', $form).length) {
                    alert('TODO: CAPCHA');
                }
                else if ($('.lander-sms', $form).length) {
                    alert('TODO: SMS');
                }
                else {
                    $form.empty().html(response);
                }
            }
            else {
                alert('TODO: JSON');
            }
            $(window).trigger('lander-send-success');
            $form.trigger('lander-send-success');
        };
        Lander.prototype.extendData = function (urlData, actionData, cookieData, generateData, formData) {
            var result = {};
            switch (window.location.hostname) {
                case 'synergyregions.ru':
                case 'sbs.edu.ru':
                    $.extend(true, result, urlData, actionData, cookieData, generateData, formData);
                    break;
                case 'synergy.ru':
                case 'synergyonline.ru':
                    $.extend(true, result, cookieData, urlData, actionData, generateData, formData);
                    break;
                default:
                    $.extend(true, result, cookieData, urlData, actionData, generateData, formData);
                    break;
            }
            return result;
        };
        Lander.prototype.setDomainCookies = function () {
            var domain = window.location.hostname;
            if (/synergyregions.ru|synergyglobal.ru/.test(domain)) {
                var exp = 0;
                var cookieName = 'GlobalPartner';
                if (domain == 'synergyregions.ru') {
                    exp = 3;
                    cookieName = 'SynergyPartner';
                }
                var expires = void 0;
                var D = new Date();
                D.setFullYear(D.getFullYear() + exp);
                expires = D.toGMTString();
                var cookieSet = {};
                cookieSet[cookieName] = this.url.partner;
                cookie.set(cookieSet, {
                    path: '/',
                    expires: expires
                });
            }
            if (/synergy\.ru|synergyonline\.ru|synergyglobal\.ru|synergy\.mba|sbs\.edu\.ru|mosap\.ru|xn\-\-80aayoegldhg0a2a2j\.xn\-\-p1ai/.test(domain)) {
                var cookies = {};
                var cookiesAll = cookie.all();
                if (!cookiesAll.utm_source && this.url.utm_source)
                    cookies.utm_source = this.url.utm_source;
                if (!cookiesAll.utm_medium && this.url.utm_medium)
                    cookies.utm_medium = this.url.utm_medium;
                if (!cookiesAll.utm_campaign && this.url.utm_campaign)
                    cookies.utm_campaign = this.url.utm_campaign;
                if (!cookiesAll.utm_content && this.url.utm_content)
                    cookies.utm_content = this.url.utm_content;
                if (!cookiesAll.utm_term && this.url.utm_term)
                    cookies.utm_term = this.url.utm_term;
                cookie.set(cookies, {
                    path: '/'
                });
            }
            return this;
        };
        Lander.prototype.saveUser = function (name, phone, email) {
            if (!this.checkLocalStorage())
                return this;
            if (name)
                localStorage.setItem('name', name);
            if (phone)
                localStorage.setItem('phone', phone);
            if (email)
                localStorage.setItem('email', email);
            return this;
        };
        Lander.prototype.generateData = function () {
            var guid = 'id_' + Math.random().toString(36).substr(2, 9);
            var mergelead = guid + Date.now();
            var cookieData = cookie.all();
            var piwikId = null;
            for (var cookie_1 in cookieData) {
                if (/_pk_id/i.test(cookie_1)) {
                    piwikId = cookieData[cookie_1];
                    break;
                }
            }
            return {
                guid: guid,
                mergelead: mergelead,
                lang: this.lang,
                refer: document.referrer,
                piwik_id: piwikId,
                PAPVisitorId: cookieData.PAPVisitorId || null,
                roistat_visit: cookieData.roistat_visit || null,
                analytics_id: cookieData._ga || null
            };
        };
        Lander.prototype.setFormLoading = function ($form) {
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
        };
        Lander.prototype.unsetFormLoading = function ($form) {
            $('input:not([data-lander-input-disabled!="disabled"]), textarea:not([data-lander-input-disabled!="disabled"]), select:not([data-lander-input-disabled!="disabled"])', $form).attr('disabled', false);
            $form.removeClass('lander-form-sending');
            $('[type="submit"]', $form)
                .removeClass('lander-form-submit-sending')
                .val($('[type="submit"]', $form).data('lander-value'));
            $('button', $form)
                .removeClass('lander-form-submit-sending')
                .html($('button', $form).data('lander-value'));
            return this;
        };
        Lander.prototype.validateFormListener = function () {
            var _this = this;
            $(document).on('change input focus', 'input.lander-invalid-input-error, \
			textarea.lander-invalid-input-error, \
			select.lander-invalid-input-error', function (ev) {
                var $el = $(ev.currentTarget).closest('form');
                var validateErrors;
                validateErrors = _this.validateForm($el);
                if (validateErrors.length) {
                    for (var i = 0; i < validateErrors.length; i++) {
                        _this.setInvalidInput(validateErrors[i]);
                    }
                }
            });
            return this;
        };
        Lander.prototype.validateForm = function ($form) {
            var _this = this;
            var errors = [];
            $('input, textarea, select', $form).each(function (index, input) {
                var $input = $(input);
                var name = $input.attr('name');
                var mask = $input.data('lander-validate-mask');
                var required = !!$input.attr('required');
                var value = $input.val() || !!$input.checked;
                var err = { $input: $input, errorMessage: false };
                if (required && !value) {
                    err.errorMessage = _this.currentLanguage.requiredField;
                }
                else {
                    switch (name) {
                        case 'name':
                            if (!_this.validateName(value, $input)) {
                                err.errorMessage = _this.currentLanguage.invalidName;
                            }
                            break;
                        case 'phone':
                            if (!_this.validatePhone(value, $input)) {
                                err.errorMessage = _this.currentLanguage.invalidPhone;
                            }
                            break;
                        case 'email':
                            if (!_this.validateEmail(value, $input)) {
                                err.errorMessage = _this.currentLanguage.invalidEmail;
                            }
                            break;
                        default:
                            if (mask && !_this.validateMask(value, mask, $input)) {
                                err.errorMessage = _this.currentLanguage.invalidMask;
                            }
                            break;
                    }
                }
                if (err.errorMessage !== false) {
                    errors.push(err);
                }
                else {
                    _this.setValidInput($input);
                }
            });
            return errors;
        };
        Lander.prototype.validateName = function (val, $input) {
            if (typeof val == 'boolean')
                return false;
            if (this.lang == 'cn')
                return true;
            var reg = /^[\wа-яёJł∫łÅÃǺǻаάẫẮắẰằẴẵÄĄªäÅÄÀÁÂåãâàάâáàÂâãΆลฉสαจЂδßβҐґŗѓΔ∂ðgġℊΣĒēĔĕĖėĘЁеěĚęΈëêξÊÈξ€Єèé€ËÉ∑∑ẾЕỀỂỄєﻉeЄєέεℯзʒυนմuหųůύϋΰÙúÚΰùÛûửữüừŨũŪūŬŭűŮK∫รI{kใรlรκIร)รķเรǨќķĶЌJlJเ∫lΛλภJI∫५ณmრฬʍ₥றभҢทฑηήnñµņңňĤĦΉŀlΉЊℋØøอσőǾŌΘŏōฮθทฑnГlթþקρÞζçÇ¢çςČċĊĉςĈćĆċčॡТדŦŤ†TτΐŢყע¥γЎұצφאхχ×ჯԱųŲҹԿ५ώωա๒ьIзЭәӘศ \-\'\`]{2,100}$/i;
            return reg.test(val);
        };
        Lander.prototype.validatePhone = function (val, $input) {
            if (typeof val == 'boolean')
                return false;
            if ($input && $input.data('lander-inputmask-inited')) {
                return $input.inputmask('isComplete');
            }
            else {
                var reg = /^[0-9\- \(\)]{5,20}/i;
                return reg.test(val);
            }
        };
        Lander.prototype.validateEmail = function (val, $input) {
            if (typeof val == 'boolean')
                return false;
            var reg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return reg.test(val);
        };
        Lander.prototype.validateMask = function (val, mask, $input) {
            if (typeof val == 'boolean')
                return false;
            var reg = new RegExp(mask, 'i');
            return reg.test(val);
        };
        Lander.prototype.setInvalidInput = function (data) {
            var $input = data.$input;
            $input.addClass('lander-invalid-input-error');
            if ($input.attr('type') == 'checkbox')
                return this;
            var $labelForInput = $input.next();
            if ($labelForInput.hasClass('lander-invalid-input-error-label')) {
                $labelForInput.html(data.errorMessage);
            }
            else {
                $input.after("<label class=\"lander-invalid-input-error-label\">" + data.errorMessage + "</label>");
            }
            return this;
        };
        Lander.prototype.setValidInput = function ($input) {
            $input
                .removeClass('lander-invalid-input-error')
                .addClass('lander-valid-input');
            if ($input.attr('type') == 'checkbox')
                return this;
            var $labelForInput = $input.next();
            if ($labelForInput.hasClass('lander-invalid-input-error-label')) {
                $labelForInput.remove();
            }
            return this;
        };
        Lander.prototype.initUrl = function () {
            this.url = url('?') || {};
            return this.url;
        };
        Lander.prototype.initUser = function () {
            var allCookie = cookie.all();
            var userCookie = {
                name: allCookie.name,
                phone: allCookie.phone,
                email: allCookie.email,
            };
            var userLocalStorage = this.getLocalStorage(['name', 'phone', 'email']);
            this.user = $.extend(true, userCookie, userLocalStorage);
            return this.user;
        };
        Lander.prototype.getLocalStorage = function (fields) {
            if (fields === void 0) { fields = []; }
            var result = {};
            if (this.checkLocalStorage()) {
                if (fields.length) {
                    result = JSON.parse(JSON.stringify(localStorage, fields));
                }
                else {
                    result = JSON.parse(JSON.stringify(localStorage));
                }
            }
            return result;
        };
        Lander.prototype.checkLocalStorage = function () {
            try {
                if (typeof localStorage == 'object') {
                    if (typeof localStorage.setItem == 'function' && typeof localStorage.getItem == 'function') {
                        return true;
                    }
                }
            }
            catch (err) {
                return false;
            }
            return false;
        };
        Lander.prototype.getUserProp = function (prop) {
            return this.user[prop] || '';
        };
        Lander.prototype.initPrivacyLinks = function () {
            var _this = this;
            $(document).on('click', '[href="#privacy"]', function (ev) {
                var url = "http://synergy.ru/lp/_chunk/privacy.php?lang=" + _this.lang + "&date=" + Date.now();
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
        };
        Lander.prototype.checkRegion = function () {
            return this;
        };
        Lander.prototype.initDevTools = function () {
            return this;
        };
        Lander.prototype.getDocumentLanguage = function () {
            var lang = document.documentElement.lang || 'ru';
            return lang;
        };
        Lander.prototype.setLanderLang = function (lang) {
            if (lang === void 0) { lang = 'ru'; }
            if (this.dictionary[lang]) {
                this.currentLanguage = this.dictionary[lang];
                return this.currentLanguage;
            }
            else {
                console.error("\u0412 \u0441\u043B\u043E\u0432\u0430\u0440\u0435 \u043B\u0435\u043D\u0434\u0435\u0440\u0430 \u043D\u0435\u0442 \u044F\u0437\u044B\u043A\u0430 " + lang);
                return false;
            }
        };
        Lander.prototype.loadResources = function (depedences, addRand) {
            var _this = this;
            if (addRand === void 0) { addRand = false; }
            var that = this;
            var _loop_1 = function (i) {
                var resource = depedences[i];
                if (Array.isArray(resource.childrens) && !resource.childrens.length) {
                    this_1.loadExternal({
                        name: resource.name,
                        url: resource.url,
                        addRand: addRand,
                        full: resource
                    }, function () {
                        resource.loaded = true;
                        _this.resourceLoaded(resource.name);
                    });
                }
                else {
                    this_1.loadExternal({
                        name: resource.name,
                        url: resource.url,
                        addRand: addRand,
                        full: resource
                    }, function () {
                        resource.loaded = true;
                        _this.resourceLoaded(resource.name);
                        _this.loadResources(resource.childrens, addRand);
                    });
                }
            };
            var this_1 = this;
            for (var i = 0; i < depedences.length; i++) {
                _loop_1(i);
            }
        };
        Lander.prototype.resourcesMap = function (resources) {
            for (var i = 0; i < resources.length; i++) {
                var resource = resources[i];
                if (Array.isArray(resource.childrens)) {
                    if (!resource.childrens.length && resource.required) {
                        this.requiredResources.push(resource.name);
                    }
                    else if (resource.childrens.length) {
                        if (resource.required) {
                            this.requiredResources.push(resource.name);
                        }
                        this.resourcesMap(resource.childrens);
                    }
                }
            }
            return this.requiredResources;
        };
        Lander.prototype.resourceLoaded = function (name) {
            var index = this.requiredResources.indexOf(name);
            if (index !== -1) {
                this.requiredResources.splice(index, 1);
            }
            if (this.requiredResources.length == 0) {
                this.start();
            }
            return this;
        };
        Lander.prototype.loadExternal = function (params, callback) {
            if (typeof params.full.afterLoad == 'function') {
                params.full.afterLoad();
            }
            if (params.full.check) {
                callback();
                return;
            }
            var name = params.name, url = params.url, addRand = params.addRand;
            var type = url.split('.').slice(-1)[0];
            if (addRand) {
                url += '?nocache=' + Math.random();
            }
            ;
            var newResource;
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
            if (typeof callback == 'function') {
                newResource.onload = function () {
                    var args = [];
                    for (var _i = 0; _i < arguments.length; _i++) {
                        args[_i] = arguments[_i];
                    }
                    if (!this.executed) {
                        this.executed = true;
                        callback.apply(void 0, ['onload'].concat(args));
                    }
                };
                newResource.onerror = function () {
                    var args = [];
                    for (var _i = 0; _i < arguments.length; _i++) {
                        args[_i] = arguments[_i];
                    }
                    if (!this.executed) {
                        this.executed = true;
                        callback.apply(void 0, ['onerror'].concat(args));
                    }
                };
                newResource.onreadystatechange = function () {
                    var _this = this;
                    if (this.readyState == 'complete' || this.readyState == 'loaded') {
                        setTimeout(function () { _this.onload(); }, 0);
                    }
                };
            }
        };
        return Lander;
    }());
    document.addEventListener("DOMContentLoaded", function () {
        window.LANDER = new Lander(window.dataLayer);
    });
})(LANDER || (LANDER = {}));
//# sourceMappingURL=lander3.0.js.map