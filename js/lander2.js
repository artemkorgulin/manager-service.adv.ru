/*  lander.js 2.2 | 2016-05-30  */

var LanderJS = (function() {

    /* Статические объекты */
    var
        LANDER = {},
        TRANSLATE = {
            ru: {sending: 'Отправка...'},
            en: {sending: 'Sending...'},
            cn: {sending: '发送'}
        },
        GLOBAL_LANG
        ;

    /* Инициализация Лендера */
    LANDER.init = function() {
        GLOBAL_LANG = $('html').attr('lang') || 'ru';

        LANDER.placeholder();       /* Плейсхолдер */
        LANDER.data_cost();         /* Подстановка стоимости */
        LANDER.form();              /* Общие обработчики форм */
        LANDER.inputMasks();        /* Маска телефона */
        LANDER.formValidation();    /* Валидация основных форм */
        LANDER.grid();              /* Сетка grid */
        LANDER.privacy();           /* Пользовательское соглашение */
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

    var
        PAPVisitorId  = LANDER.get_cookie('PAPVisitorId'),
        roistat_visit = LANDER.get_cookie('roistat_visit'),
        owa_visitorId = LANDER.get_cookie('owa_v'),
        owa_sessionId = LANDER.get_cookie('owa_s'),
        analytics_id  = LANDER.get_cookie('_ga'),
        dataLayer     = window.dataLayer || []
        ;

    /* Подстановка стоимости из атрибута "data-cost" тега radio */
    LANDER.data_cost = function() {
        $('[name=radio]').change(function () {
            $('form').attr('data-cost', $('input[type=radio]:checked').attr('data-cost'));
        });
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
                    guid     = ID(),
                    unit     = $form.data('unit'),
                    type     = $form.data('type'),
                    land     = $form.data('land'),
                    version  = $form.data('version'),
                    partner  = LANDER.getQuery('partner'),
                    form     = $form.data('form'),
                    cost     = $form.data('cost'),
                    landname = $form.data('landname'),
                    speaker  = $form.data('speaker'),
                    program  = $form.data('program'),
                    dater    = $form.data('dater'),
                    lang     = $form.data('lang'),
                    link     = $form.data('link'),
                    name     = $form.find('[name=name]').val(),
                    phone    = $form.find('[name=phone]').val(),
                    email    = $form.find('[name=email]').val(),
                    refer    = document.referrer
                    ;

                if (partner)       $form.append('<input type="hidden" name="partner" value="' + partner + '">');
                if (refer)         $form.append('<input type="hidden" name="refer" value="' + refer + '">');
                if (cost)          $form.append('<input type="hidden" name="cost" value="' + cost + '">');
                if (PAPVisitorId)  $form.append('<input type="hidden" name="PAPVisitorId" value="' + PAPVisitorId + '">');
                if (roistat_visit) $form.append('<input type="hidden" name="roistat_visit" value="' + roistat_visit + '">');
                if (owa_visitorId) $form.append('<input type="hidden" name="owa_visitorId" value="' + owa_visitorId + '">');
                if (owa_sessionId) $form.append('<input type="hidden" name="owa_sessionId" value="' + owa_sessionId + '">');
                if (analytics_id)  $form.append('<input type="hidden" name="analytics_id" value="' + analytics_id + '">');

                /* Отправка данных в GTM */
                dataLayer.push(
                    {'gtm.element.dataset.guid': guid},
                    {'gtm.element.dataset.landname': landname},
                    {'gtm.element.dataset.version': version},
                    {'gtm.element.dataset.form': form},
                    {'gtm.element.dataset.phone': phone},
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
            /* Показать системную информацию по Ctrl+Click */
            .on('click', function (e) {
                if (e.ctrlKey || e.metaKey) {
                    var
                        systeminfo = '',
                        clearqueryCtrl = $(this).attr('action').split('?'),
                        superqueryCtrl = clearqueryCtrl[1],
                        splitterCtrl = superqueryCtrl.split('&')
                        ;

                    splitterCtrl.forEach(function (entry) {
                        var keys = entry.split('=');
                        if (!keys[0]) return;
                        systeminfo += '<tr><td>' + keys[0] + ':</td><td>' + decodeURIComponent(keys[1]) + '</td></tr>';
                    });
                    /* Показываем красивый алерт с системной информацией */
                    $('body').append('<div id="lander-form-system-info" style="z-index: 99999; display: table; width: 100%; height: 100%; position: fixed; left:0; top:0"><style>#lander-form-system-info td{width:48%;text-align:right;padding-right:10px;font-weight:bold;}#lander-form-system-info td+td{width:50%;text-align:left;font-weight:normal;}</style><div style="display: table-cell; vertical-align: middle; text-align: center;"><div style="background: rgb(255, 255, 255); min-width: 500px; padding: 10px 20px 20px; border-radius: 5px; text-align: center; display: inline-block; margin: 0 auto; box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);"><h2 style="color: #575757;font-size: 30px;text-align: center;font-weight: 600;text-transform: none;position: relative;margin: 10px 0 25px;padding: 0;line-height: 40px;display: block;">Системная информация</h2><table style="color: #575757;font-size: 16px;" width="100%">' + systeminfo + '</table><div class="sa-button-container"> <button style="color: rgb(255, 255, 255); border: medium none; font-size: 18px; font-weight: 500; border-radius: 5px; line-height: 44px; cursor: pointer; margin-top: 35px; padding: 0 15px; display: inline-block; background-color: rgb(174, 222, 244); box-shadow: 0 0 2px rgba(174, 222, 244, 0.8), 0 0 0 1px rgba(0, 0, 0, 0.05) inset;" >Закрыть</button></div></div></div></div>');
                    $(document).on('click', '#lander-form-system-info button', function(){
                        $('#lander-form-system-info').remove();
                        return false;
                    });
                }
            })
            .each(function () {
                /* Кодирование кириллицы в action форм для IE */
                var $form = $(this);
                if ($form.data('inited') == 'inited') return;

                LANDER.encodeFormAction($form);
                $form.data('inited', 'inited');
            })
            /* После перезагрузки страницы у элементов форм убираем атрибут disabled="", установленный ранее через .attr(), и не трогаем те, которые по умолчанию имеют атрибут disabled="true" */
            .find(':disabled').not('[disabled="true"]').removeAttr('disabled');

        /* Подстановка данных из локальной БД пользователя */
        if (localStorage.getItem('name'))  {$('[name=name]').val(localStorage.getItem('name')).trigger('change').addClass('GoodLocal');}
        if (localStorage.getItem('phone')) {$('[name=phone]').val(localStorage.getItem('phone')).trigger('change');}
        if (localStorage.getItem('email')) {$('[name=email]').val(localStorage.getItem('email')).trigger('change');}
    };

    /* Автоматическая подстановка маски под номер телефона */
    LANDER.inputMasks = function() {
        $('[name="phone"]:not([data-inputmasks-inited]), [type="tel"]:not([data-inputmasks-inited])').each(function() {
            $(this).inputmask("phone", {
                url: 'http://synergy.ru/lander/alm/js/phone-codes.json',
                onKeyValidation: function () {}
            }).attr('data-inputmasks-inited', '');
        });
    };

    /* Дополнительный метод валидации имени */
    LANDER.formValidationMethod = function() {
        $.validator.addMethod('valname', function (value, element) {
            return this.optional(element) || /^[А-Яа-яЁёA-Za-z\s]{2,100}$/.test(value);
        }, 'Введите корректное имя');

        /* Дополнительный метод валидации email */
        $.validator.addMethod('valemail', function (value, element) {
            return this.optional(element) || /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(value);
        }, 'Введите корректный e-mail');

        /* Перевод валидации на русский язык */
        $.extend($.validator.messages, {
            required : 'Обязательное поле',
            remote   : 'Пожалуйста, введите правильное значение.',
            email    : 'Пожалуйста, введите корректный адрес E-mail.',
            number   : 'Пожалуйста, введите цифры.',
            maxlength: $.validator.format('Пожалуйста, введите не больше {0} символов.'),
            minlength: $.validator.format('Пожалуйста, введите не меньше {0} символов.')
        });
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
                $(form).parents('.send-success').parent().html(data);
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

                if ($('[data-form=smsver]').length)
                    LANDER.formSmsVer('[data-form=smsver]');
            });
            return false;
        });
    };

    /* Валидация формы */
    LANDER.formValidation = function() {
        LANDER.formValidationMethod();

        /* Валидация и аякс отправка форм с смс-верификацией */
        $('form').not('#mse2_form, .nolander').each(function(){
            var
                $form = $(this),
                lang = $form.attr('data-lang') || GLOBAL_LANG
                ;

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
                    "phone": {required: true, minlength: 11, maxlength: 25},
                    'email': {required: true, email: true, valemail: true},
                    'number':{required: true, number: true, min: 1}
                },
                /* Ajax отправка формы */
                submitHandler: function (form) {
                    var target = $(form).is('.notarget') ? $(form).find('.target').attr('action') : $(form).attr('action'),
                        fields = LANDER.formFields(form);

                    /* Блокирование полей и кнопки формы */
                    var valSubmit = $(form).find(':submit').val();

                    $(form).find('input').attr('disabled', '');
                    $(form).find(':submit').attr({
                        'disabled': '',
                        'value'   : TRANSLATE[lang]['sending']
                    }).addClass('loading');

                    $.ajax({
                        url   : target,
                        method: "POST",
                        data  : fields
                    }).done(function(data) {
                        LANDER.Hash.add('send','ok');
                        dataLayer.push({'event': 'gtm.formSubmit'});

                        if(data!='') {
                            $(form).html(data);

                            var smsver = $('[data-form=smsver]'),
                                dcap   = $('#duplicate-capcha');

                            if (smsver.length || dcap.length) {
                                if (smsver.length)
                                    form = smsver;
                                if (dcap.length)
                                    form = dcap;


                                form.on('submit', function () {
                                    fields = LANDER.formFields(form);

                                    $.ajax({
                                        url: $(this).attr('action'),
                                        method: "POST",
                                        data: fields
                                    }).done(function (data) {
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
                            $(form).find('input, :submit').removeAttr('disabled');
                            $(form).find(':submit').val(valSubmit).removeClass('loading');
                        }

                        $(form).trigger('send-success');

                        if($('.target').length)
                            $(form).find('.target').show();
                    });

                    return false;
                }
            })
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
    };

    /* Подгрузка Пользовательского соглашения  */
    LANDER.privacy = function() {
        function InitFancyPrivacy() {
            $('.privacy-ajax')
                .attr('href', 'http://synergy.ru/lp/_chunk/privacy.php')
                .fancybox({
                    maxWidth: 800,
                    autoResize: true
                });
        }

        if (!$.fn.fancybox) {
            var script = document.createElement('script');
            script.src = "http://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js";
            document.body.appendChild(script);
            script.onload = function () {
                if (!this.executed) { /* Выполнится только один раз*/
                    this.executed = true;
                    InitFancyPrivacy();
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
            $('head').append('<link href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet" type="text/css">');
        } else {
            InitFancyPrivacy();
        }
    };


    /* Выводит сетку для теста верстки по Ctrl+Shift+Alt */
    $(document).on('keydown', function(event) {
        if(event.ctrlKey == 1 && event.shiftKey == 1 && event.altKey == 1) {
            localStorage.setItem('grid-tool', localStorage.getItem('grid-tool') != 'yes' ? 'yes' : 'no' );
            $('body').toggleClass('grid-tool_active_yes');
        }
    });

    return LANDER;
})();

LanderJS.init();

function recaptchaCallback(){
    $('#duplicate-capcha :submit').addClass('recaptcha-success');
}