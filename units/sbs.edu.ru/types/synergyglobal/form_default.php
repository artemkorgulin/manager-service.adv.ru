<?php
####################
##### Вебинары SYNERGY GLOBAL FORUM #####
####################


/* Дефолтные параметры */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sgf'); // было webinar

$config['ignore']['send_to_user'] = true;

$default_sendsuccess = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
</div>
";

$config['user']['sendsuccess'] = $default_sendsuccess;
$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на Synergy Global Forum 2016";

$partner_program_file = 'http://sbs.edu.ru/assets/images/download/SGF_2016_program.pdf'; /* PDF-файл программы в письмах для версий */


if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Your request was sent succesfully!</h3>
		<p>Check your email <b>{$lead->email}</b>, we&rsquo;d sent you a&nbsp;letter with further instructions.</p>
	</div>
	";
	$config['mail']['smtp']['user']['subject'] = "Successful registration at Synergy Global Forum 2016!";

	$partner_program_file = 'http://sbs.edu.ru/assets/images/download/SGF_2016_program_en.pdf';
}


/* Для некоторых партнеров заменяем телефон : https://sd.synergy.ru/Task/View/99720 */
switch ($lead->partner) {
	case 'novosibirskbo': $partner_phone = '+7 (383) 319-15-59'; break;
	case 'krasnoyarsk': $partner_phone = '+7 (391) 200-81-58'; break;
	case 'ekb': $partner_phone = '+7 (800) 700-56-24; +7 (966) 700-00-69'; break;
	case 'orenburg':
	case 'rnd':
	case 'spb':
	case 'sta':
	case 'ufa':
	case 'drb':
	case 'omsk':
	case 'tomsk':
	case 'kazan':
	case 'chelyabinsk':
	case 'samara':
	$partner_phone = '+7 (812) 611-11-48';
	break;
	case 'nn': $partner_phone = '+7 (915) 944-25-02'; break;
	case 'kg': $partner_phone = '+7 (921) 260-10-50'; break;
	case 'krdr': $partner_phone = '+7 (964) 899-90-07'; break;
}


/* Для http://synergyglobal.ru/?partner=kz : https://sd.synergy.ru/Task/View/84597 */
if ( $lead->partner == 'kz' ) {
	$partner_phone = '+7 727 237 77 75, +7 707 322 52 88';

	$partner_program_file = 'http://sbs.edu.ru/assets/images/download/SGF_2016_program_kz.pdf';
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/default.php';



if ( $_REQUEST['land'] == 'tehran-sglobal' || $_REQUEST['land'] == 'tehran-sglobal-ru' ) {
	$program_file = 'http://sbs.edu.ru/assets/images/download/SGF_Tehran_2017_program.pdf';

	/* Для http://synergyglobal.ru/tehran/ */
	if ( $_REQUEST['lang'] == 'en' ) {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Request successfully submitted!</h3>
			<p>Check your e-mail <b>{$lead->email}</b>, which will receive a&nbsp;letter with further instructions.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "Successful registration Synergy Global Tehran Forum 2017";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/tehran.php';

		if ( $lead->form == 'partner' || $lead->form == 'sponsor' || $lead->form == 'agent') {
			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Thank you!</h3>
				<p>We&nbsp;are pleased to&nbsp;welcome you among the official Synergy Global Forum partners. Please find collaboration letter on&nbsp;your e-mail <b>{$lead->email}</b>.</p>
			</div>
			";

			$config['mail']['smtp']['user']['subject'] = "Become a sponsor or a parnter of Synergy Global Forum Tehran 2017";
			$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/partner.php';
		}
	}

	/* Для http://synergyglobal.ru/tehran/ru/ */
	else {
		$program_file = 'http://sbs.edu.ru/assets/images/download/SGF_Tehran_2017_program_ru.pdf';

		if ( $lead->cost ) {
			$payment_link = "http://synergyglobalteheran.ticketforevent.com/ru/seat/";
			$payment_link_iframe = $payment_link . "forembed/922/";
			$redirect = "<script>setTimeout(function(){ $('#payment_link_iframe').trigger('init').trigger('click'); }, 1000);</script>";

			if ( $lead->comments == 'ЭКСПО' ) {
				$payment_link .= '?promocode=экспо';
				$payment_link_iframe .= '?promocode=экспо';
			}

			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Спасибо!</h3>
				<p>Сейчас вы&nbsp;можете <a href='{$payment_link_iframe}' target='_blank' id='payment_link_iframe' class='fancy fancybox.iframe' data-fancybox-options='{minWidth:922,minHeight:595}'>выбрать места и&nbsp;оплатить билеты</a>.</p>
			</div>
			{$redirect}
			";

			if($_REQUEST['cost'] == 'по запросу'){
				$payment_link = '';
				$redirect = '';
				$config['user']['sendsuccess'] = $default_sendsuccess;
			}
		}

		/* https://sd.synergy.ru/Task/View/98716 */
		/* Для некоторых партнеров заменяем кнопку заказа билетов на ссылку http://synergyregions.ru */
		if ( preg_match( '/^(ekb|kg|krdr|nn|novosibirskbo|orenburg|rnd|spb|sta|krasnoyarsk|ufa|drb|omsk|tomsk|kazan|chelyabinsk|samara|zavod-.*)$/i', $lead->partner ) ) {
			$config['user']['sendsuccess'] = "
			{$default_sendsuccess}
			<p><a href='http://synergyregions.ru?utm_source={$lead->land}' target='_blank' class='button'>Перейти на&nbsp;сайт</a></p>
			";
			$payment_link = '';
		}


		$config['mail']['smtp']['user']['subject'] = "Регистрация на Synergy Global Тегеран Forum 2017";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/tehran.php';
	}


	/* Для форм "Скачать программу" */
	if ( $lead->form == 'download' ) {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>Программа форума была направлена на&nbsp;указанный электронный адрес.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "Ваша программа Synergy Global Forum Тегеран 2017";

		if ( $_REQUEST['lang'] == 'en' ) {
			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Request is&nbsp;sent successfully!</h3>
				<p>The forum program was sent to&nbsp;the specified e-mail address.</p>
			</div>
			";

			$config['mail']['smtp']['user']['subject'] = "Program of Synergy Global Forum Tehran 2017";
		}

		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/tehran_download.php';
	}

	if ( $lead->form == 'reg_table-gas' || $lead->form == 'reg_table-bank' || $lead->form == 'reg_table-room' || $lead->form == 'reg_table-car' || $lead->form == 'reg_table-offer') {

		if($lead->form == 'reg_table-offer'){

			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>Ваша тема круглого стола принята на модерацию</p>
			</div>
			";

			$config['mail']['smtp']['user']['subject'] = "SGF в Тегеране — ваша тема круглого стола принята на модерацию";

			$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/tehran_table-offer.php';

		}
		else{

			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>Вы успешно зарегистрировались на участие в круглом столе.</p>
			</div>
			";

			$tehran_table_name = "";

			switch($lead->form){

				case 'reg_table-gas':
				$tehran_table_name = 'Сотрудничество в нефтегазовой отрасли';
				break;
				case 'reg_table-bank':
				$tehran_table_name = 'Совместные проекты в банковской сфере';
				break;
				case 'reg_table-room':
				$tehran_table_name = 'Жилая и коммерческая недвижимость';
				break;
				case 'reg_table-car':
				$tehran_table_name = 'Развитие городской инфраструктуры';
				break;

			}

			$config['mail']['smtp']['user']['subject'] = "SGF в Тегеране — участие в круглом столе $tehran_table_name";

			$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/tehran_table-reg.php';

		}


	}
	if ( $lead->form == 'excursion') {

		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>В ближайшее время с вами свяжется наш специалист, чтобы обсудить детали поездки.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "SGF в Тегеране — участие в культурной программе";

		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/excursion.php';

	}

}

/* Для http://synergyglobal.ru/miss/ */
elseif ( $_REQUEST['land'] == 'miss_global' ) {

	if($_REQUEST['form'] == 'mainSecond'){
		$config['mail']['smtp']['user']['subject'] = "Правила участия в конкурсе Мисс Synergy Global Forum";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/miss_pravila.php';
	}
	else{
		$config['mail']['smtp']['user']['subject'] = "Регистрация на конкурс Мисс SGF2016";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/miss.php';
	}

}

/* Для http://synergy.ru/lp/sgf-free/ */
/* https://sd.synergy.ru/task/view/97126 */
elseif ( $_REQUEST['land'] == 'sgf-free' ) {

	$config['ignore']['send_to_user'] = false;

}

/* Для основного http://synergyglobal.ru и остальных */
else {

	/*
	if ( $lead->form == 'mainFirst' ) {
		$config['user']['sendsuccess'] = '
		<div class="send-success">
			<div id="form-price" class="form-price">
				<!-- <a href="https://shkola-biznesa-sine.timepad.ru/event/336334/" data-twf-placeholder="yes">Перейти к заказу билетов</a> -->
				<script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="16277" data-timepad-widget-v2="event_register" src="https://timepad.ru/js/tpwf/loader/min/loader.js">
					(function(){
						return {
							"event":{"id":"336334"},
							"bindEvents":{"postRepaint": "handleTWFpost"},
							"prefill":{
								"attendees": [
								{
									"name": $("#price-form-name").val(),
									"mail": $("#price-form-mail").val()
								}
								]
							}
						};
					})();
				</script>
			</div>
		</div>

		<input id="price-form-name" type="hidden" value="' . $lead->name . '">
		<input id="price-form-mail" type="hidden" value="' . $lead->email . '">

		<script>
			$.fancybox($("#form-price"), {
				minWidth  : 700,
				autoResize: true,
				nextEffect: "none",
				prevEffect: "none",
				padding   : 0,
				autoHeight: true
			});

			function fancyUpdate(t){
				setTimeout(function(){
					$.fancybox.update();
				}, t);
			}

			var handleTWFpost = function(params) {
				setTimeout(fancyUpdate(2000), 1000);
				this.$$("select.b-reg-table__select").on("change", function(){
					fancyUpdate(1000);
				});
			}

			$(".app-main.form, .form_price_init").html("<h4>Спасибо! <br>Вы уже оставили заявку</h4><!-- <a rel=\\"nofollow\\" target=\\"_blank\\" href=\\"https://shkola-biznesa-sine.timepad.ru/event/336334/#register\\">Перейти к выбору билета</a> -->");
		</script>
		';
	}

	elseif ( $lead->form == 'mainFooter' ) {
		$config['user']['sendsuccess'] = '
		<div class="send-success">

			<div id="form-price2" class="form-price">
				<!-- <a href="https://shkola-biznesa-sine.timepad.ru/event/336334/" data-twf-placeholder="yes">Перейти к заказу билетов</a> -->
				<script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="16277" data-timepad-widget-v2="event_register" src="https://timepad.ru/js/tpwf/loader/min/loader.js">
					(function(){
						return {
							"event":{"id":"336334"},
							"bindEvents":{"postRepaint": "handleTWFpost"},
							"prefill":{
								"attendees": [
								{
									"name": $("#price-form-name").val(),
									"mail": $("#price-form-mail").val()
								}
								]
							}
						};
					})();
				</script>
			</div>
		</div>

		<input id="price-form-name" type="hidden" value="' . $lead->name . '">
		<input id="price-form-mail" type="hidden" value="' . $lead->email . '">

		<script>
			$.fancybox($("#form-price2"), {
				minWidth  : 700,
				autoResize: true,
				nextEffect: "none",
				prevEffect: "none",
				padding   : 0,
				autoHeight: true
			});

			function fancyUpdate(t){
				setTimeout(function(){
					$.fancybox.update();
				}, t);
			}

			var handleTWFpost = function(params) {
				setTimeout(fancyUpdate(2000), 1000);
				this.$$("select.b-reg-table__select").on("change", function(){
					fancyUpdate(1000);
				});
			}

			$(".app-main.form, .form_price_init").html("<div class=\\"form_price_thanks\\"><h4>Спасибо! <br>Вы уже оставили заявку</h4><!-- <a rel=\\"nofollow\\" target=\\"_blank\\" href=\\"https://shkola-biznesa-sine.timepad.ru/event/336334/#register\\">Перейти к выбору билета</a> --></div>");

		</script>
		';
	}

	elseif ( $lead->form == 'price' ) {
		$config['user']['sendsuccess'] = '
		<div class="send-success">
			<input id="price-form-name" type="hidden" value="' . $lead->name . '">
			<input id="price-form-mail" type="hidden" value="' . $lead->email . '">
			<script>
				function fancyUpdate(t){
					setTimeout(function(){
						$.fancybox.update();
					}, t);
				}
				var handleTWFpostRepaint = function(params) {
					setTimeout(fancyUpdate(1000), 200);
					this.$$("select.b-reg-table__select").on("change", function(){
						fancyUpdate(1000);
					});
					this.$$("#eventreg_submit").on("click", function(){
						fancyUpdate(1000);
					});
				}

				$("#lendbottom .form_price_thanks, .lendtop .form_price_thanks").show();
				$(".app-main.form").remove();
			</script>
			<!-- <a href="https://shkola-biznesa-sine.timepad.ru/event/336334/" data-twf-placeholder="yes">Перейти к заказу билетов</a> -->
			<script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="16277" data-timepad-widget-v2="event_register" src="https://timepad.ru/js/tpwf/loader/min/loader.js">
				(function(){
					return {
						"event":{"id":"336334"},
						"bindEvents":{"postRepaint": "handleTWFpostRepaint"},
						"prefill":{
							"attendees": [
							{
								"name": $("#price-form-name").val(),
								"mail": $("#price-form-mail").val()
							}
							]
						}
					};
				})();
			</script>
		</div>
		';
	}
	*/

	if ( $lead->form == 'partner' || $lead->form == 'sponsor' || $lead->form == 'agent') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо!</h3>
			<p>Мы&nbsp;рады приветствовать Вас в&nbsp;числе официальных партнеров форума. <br>На&nbsp;Ваш e-mail <b>{$lead->email}</b> направленно письмо с&nbsp;предложением о&nbsp;сотрудничестве.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "Станьте партнером главного бизнес-события года Synergy Global Forum 2016";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/partner.php';
	}

	elseif ( $lead->form == 'tegeran' ) {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на Synergy Global Forum Tehran 2016";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/tegeran.php';
	}

	elseif ( $lead->form == 'application' ) {
		$config['mail']['smtp']['user']['subject'] = "Ваше приложение Synergy Friends для активного нетворкинга";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/application.php';
	}

	/* https://sd.synergy.ru/task/view/84479 */
	elseif ( $lead->form == 'special_offer' ) {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо за&nbsp;вашу заявку!</h3>
			<p>Письмо со&nbsp;ссылками на&nbsp;видеозаписи будет направлено вам в&nbsp;ближайшее время.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "Видеозапись SGF 2015 в подарок";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/special_offer.php';
	}

	elseif ( $lead->form == 'download' ) {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>Программа форума была направлена на&nbsp;указанный электронный адрес.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "Ваша программа Synergy Global Forum 2016";

		if ( $_REQUEST['lang'] == 'en' ) {
			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Request is&nbsp;sent successfully!</h3>
				<p>The forum program was sent to&nbsp;the specified e-mail address.</p>
			</div>
			";

			$config['mail']['smtp']['user']['subject'] = "Program of Synergy Global Forum 2016";
		}

		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/download.php';
	}

	/* https://sd.synergy.ru/Task/View/85626 */
	elseif ( $lead->form == 'main-corp' ) {
		$config['user']['sendsuccess'] = '
		<div class="send-success">
			<h3>Спасибо!</h3>
			<p>Корпоративный заказ принят. В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы, забронировать билет по&nbsp;специальной цене и&nbsp;выставить счет.</p>
		</div>
		';
		$config['mail']['smtp']['user']['subject'] = "Ваша заявка на корпоративное участие в SGF2016 принята";

		if ( $_REQUEST['lang'] == 'en' ) {
			$config['user']['sendsuccess'] = '
			<div class="send-success">
				<h3>Thank you!</h3>
				<p>Your corporate order was succesfuly sent, our account-manager will connect with you as&nbsp;soon as&nbsp;possible to&nbsp;book your tickets at&nbsp;a&nbsp;special price and to&nbsp;prepare the invoice.</p>
			</div>
			';
			$config['mail']['smtp']['user']['subject'] = "Your request for corporate participation at SGF2016 is received";
		}

		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/main-corp.php';
	}

	/* https://sd.synergy.ru/task/view/90723 */
	elseif ( $lead->form == 'book-place' ) {
		$config['user']['sendsuccess'] = '
		<div class="send-success">
			<h3>Ваша заявка отправлена!</h3>
			<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время, чтобы обсудить возможности размещения вашего стенда в&nbsp;Crocus City.</p>
		</div>
		';
		$config['ignore']['send_to_user'] = false;
	}

	/* https://sd.synergy.ru/task/view/95128 */
	elseif ( $lead->form == 'get-demos-2016' ) {
		$config['user']['sendsuccess'] = '
		<div class="send-success">
			<h3>Ваша заявка отправлена!</h3>
			<p>Проверьте свой e-mail, мы&nbsp;выслали на&nbsp;него письмо с&nbsp;демо-записями.</p>
		</div>
		';
		$config['ignore']['send_to_user'] = false;
	}

}


/* Для http://www.synergyglobal.ru/videorecording/ */
if ( $_REQUEST['land'] == 'videorecording-sglobal' ){
	$lead->link = "https://Merchant.IntellectMoney.ru/ru/index.php?email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYEE_PURSE=452781&LMI_PAYMENT_DESC=Оплата+доступа+к+видеоматериалам+«{$lead->program}»";
	$config['mail']['smtp']['user']['subject'] = "Ваш доступ к видеозаписям SYNERGY GLOBAL FORUM";

	$redirect = "<script>setTimeout(function(){ location.replace('{$lead->link}'); }, 3000);</script>";
	$config['user']['sendsuccess'] .= $redirect;
}

if ( $_REQUEST['lang'] == 'ir' ) {

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3> درخواست با موفقیت ارسال شد!</h3>
		<p>ایمیل های خود از <b>{$lead->email}</b> را چک کنید که در آن نامه ای همراه با دستورالعمل های بیشتر ارسال خواهد شد.</p>
	</div>";

	$config['ignore']['send_to_user'] = false;

}
	/*$config['mail']['smtp']['user']['subject'] = "Successful registration at Synergy Global Forum 2016!";
	$config['mail']['smtp']['user']['message'] = "<p>شما در همایش بین المللی سینرجی تهران ثبت نام کردید. همایش در 22-20 فوریه سال 2017 در پایتخت ایران، تهران، در برج میلاد برگزار می شود.</p>
<p>شما منتظر سخنرانی آلن پیزا، جان تسچل و دیگر سخنرانان برجسته بین المللی و همچنین برنامه تجاری در میز گردها باشید.</p>
<p>از شما به خاطر تلاش برای بودن با ما سپاسگذاریم!</p>
<p>گوشی خود را در دسترس قرار دهید: ما با شما تماس می گیریم و به طور مفصل در مورد چگونگی پرداخت برای مشارکت شما در همایش توضیح می دهیم.</p>";

	$partner_program_file = 'http://sbs.edu.ru/assets/images/download/SGF_2016_program_en.pdf';

	if ( $lead->form == 'download' ) {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>Программа форума была направлена на&nbsp;указанный электронный адрес.</p>
		</div>
		";

		$config['mail']['smtp']['user']['subject'] = "Ваша программа Synergy Global Forum Тегеран 2017";

		if ( $_REQUEST['lang'] == 'en' ) {
			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Request is&nbsp;sent successfully!</h3>
				<p>The forum program was sent to&nbsp;the specified e-mail address.</p>
			</div>
			";

			$config['mail']['smtp']['user']['subject'] = "Program of Synergy Global Forum Tehran 2017";
		}

		$config['mail']['smtp']['user']['message'] = "";
	}

	if ( $lead->form == 'reg_table-gas' || $lead->form == 'reg_table-bank' || $lead->form == 'reg_table-room' || $lead->form == 'reg_table-car' || $lead->form == 'reg_table-offer') {

		if($lead->form == 'reg_table-offer'){

			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3> درخواست با موفقیت ارسال شد!</h3>
				<p>همایش بین المللی سینرجی- موضوع شما در محدوده موضوعی میز گرد پذیرفته شد.</p>
			</div>";

			$config['mail']['smtp']['user']['subject'] = "همایش بین المللی سینرجی- موضوع شما در محدوده موضوعی میز گرد پذیرفته شد.";

			$config['mail']['smtp']['user']['message'] = "<p>از توجه شما نسبت به اقدامات ما و توسعه روابط تجاری ایران و روسیه سپاسگذاریم. موضوع پیشنهادی خود را به مدیریت برنامه های ما بفرستید. اگر یک موضوع برای بحث مجاز بود، ما آن را در مواد مورد بحث (دستور کار) قرار خواهیم داد.</p>
				<p>به امید دیدار!</p>
				<p>گروه مدرسه کسب و کار (بازرگانی) سینرجی</p>";

		}
		else{

			$tehran_table_name = "";

			switch($lead->form){

				case 'reg_table-gas':
				$tehran_table_name = 'Сотрудничество в нефтегазовой отрасли';
				break;
				case 'reg_table-bank':
				$tehran_table_name = 'Совместные проекты в банковской сфере';
				break;
				case 'reg_table-room':
				$tehran_table_name = 'Жилая и коммерческая недвижимость';
				break;
				case 'reg_table-car':
				$tehran_table_name = 'Развитие городской инфраструктуры';
				break;

			}

			$config['mail']['smtp']['user']['subject'] = "SGF в Тегеране — участие в круглом столе $tehran_table_name";

			$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyglobal/tehran_table-reg.php';

		}


	}

}*/