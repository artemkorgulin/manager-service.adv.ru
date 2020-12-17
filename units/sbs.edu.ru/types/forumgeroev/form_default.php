<?php
###############################
########## Форум Героев #######
###############################

$payment_redirect = "
<p>Переход на систему оплаты...</p>
<script>setTimeout(function(){ location.href = 'https://shkola-biznesa-sine.timepad.ru/event/510926/#register'; }, 500);</script>
";

/*if( !empty($lead->cost) ){
	$payment_redirect = '
	<p>
		<a href="https://shkola-biznesa-sine.timepad.ru/event/510926/" data-twf-placeholder="yes">Купить билет</a>
		<script type="text/javascript" async="async" defer="defer" charset="UTF-8" src="https://timepad.ru/js/tpwf/loader/min/loader.js" data-timepad-customized="16277" data-twf2s-event--id="510926" data-timepad-widget-v2="event_register">
			(function(){
				return {
					"event":{"id":"510926"},
					"hidePreloading":true,
					"initialRoute":"button",
					"buttonSettings":{
						"text":"Купить билет",
						"height": "60",
						"css":{
							"display": "block",
							"width": "190px",
							"height": "60px",
							"font-size": "16px",
							"font-family": "SFUIDisplay, Arial, sans-serif",
							"font-weight": "700",
							"letter-spacing": "3px",
							"line-height": "16px",
							"text-transform": "uppercase",
							"border": "none",
							"border-radius": "0",
							"background": "#ed1846",
							"box-shadow": "0 5px 15px rgba(189, 1, 42, .4)",
							"padding": "0 2rem",
							"cursor": "pointer"
						}
					}
				}
			})();
		</script>
	</p>
	';
}*/


/* https://sd.synergy.ru/Task/View/98716 */
/* Для некоторых партнеров заменяем кнопку заказа билетов на ссылку http://synergyregions.ru */
if ( preg_match( '/^(ekb|kg|krdr|nn|novosibirskbo|orenburg|rnd|spb|sta|krasnoyarsk|ufa|drb|omsk|tomsk|kazan|chelyabinsk|samara|zavod-.*)$/i', $lead->partner ) ) {
	$payment_redirect = "<p><a href='http://synergyregions.ru?utm_source={$lead->land}' target='_blank' class='btn'>Перейти на&nbsp;сайт</a></p>";
}

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо! Ваша заявка отправлена.</h3>
	<p>Мы направили подтверждение регистрации на ваш email.</p>
	{$payment_redirect}
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>
";



/* Дефолтный обработчик */
/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = true;
/* Конфигуратор UserMail */
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на предпринимательский форум Героев российского бизнеса";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_forumgeroev.php';

if ($lead->form =='subscription') {
	$config['ignore']['getresponse'] = true;
	$config['ignore']['send_to_user']   = false;
}

if ($lead->form =='subscription-lp-17' && $lead->land =='forumgeroev') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо! Ваша заявка отправлена.</h3>
		<p>Уже совсем скоро вы&nbsp;получите первое письмо с&nbsp;видео выступления спикера форума &laquo;Герои российского бизнеса 2016&raquo;.</p>
	</div>
	";
}

if ($lead->form =='prgrm') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо за вашу заявку!</h3>
		<p>Программа форума направлена на&nbsp;ваш электронный адрес.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>
	";

	$config['mail']['smtp']['user']['subject'] = "Ваша программа Предпринимательского форума «Герои российского бизнеса 2017»";
}

if ($lead->form =='form-partner') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<p>Спасибо, ваша заявка отправлена! Мы свяжемся с&nbsp;вами в&nbsp;ближайшее время, чтобы обсудить возможности нашего сотрудничества.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>
	";
}



if($_REQUEST['version'] == 'tickets1001'){

	$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо! Ваша заявка отправлена.</h3>
			<p>Для выбора билетов в зале, перейдите по ссылке <a href='#' class='open1001'>выбор билетов</a>.</p>
		</div>
		<script>
		$.extend(true, window.api1001_params, {

			defaults: {

				name: '{$lead->name}',
				phone: '{$lead->phone}',
				email: '{$lead->email}',
				comment: 'test'

			},
			additionally: {

				mergelead: {
					name: 'mergelead',
					value: '{$lead->mergelead}'
				},
				land: {
					name: 'land',
					value: '{$lead->land}'
				}

			}

		});
		</script>
	";

}