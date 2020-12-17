<?php
####################
##### Вебинары SYNERGY GLOBAL FORUM #####
####################


/* Дефолтные параметры */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sgf'); // было webinar

$config['ignore']['send_to_user'] = true;

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
</div>
";
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
			$intellectmoney_link = "https://Merchant.IntellectMoney.ru/ru/index.php?email={$lead->email}&LMI_PAYEE_PURSE=455445&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC=Оплата+участия+в+Synergy+Global+Forum+Tehran&preference=bankCard";
			$redirect = "<script>setTimeout(function(){ location.replace('{$intellectmoney_link}'); }, 3000);</script>";

			$config['user']['sendsuccess'] .= "
			<div class='send-success'>
				<p>Сейчас вы&nbsp;будете перенаправлены на&nbsp;<a href='{$intellectmoney_link}' target='_blank'>страницу оплаты</a>.</p>
			</div>
			{$redirect}
			";
		}

		$config['mail']['smtp']['user']['subject'] = "Регистрация на Synergy Global Tehran Forum 2017";
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

		$config['mail']['smtp']['user']['subject'] = "Ваша программа Synergy Global Forum Tehran 2017";

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
