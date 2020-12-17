<?php
###############################
########## Форум Героев #######
###############################

$partner_phone = '8 800 707 41 77';

switch ($lead->partner) {

	/* https://sd.synergy.ru/Task/View/122304 */
	case 'chelyabinsk':			$partner_phone = '8 800 301-20-10';		break;
	case 'drb':					$partner_phone = '8 800 301-20-10';		break;
	case 'ekb':					$partner_phone = '8 800 700-56-24';		break;
	case 'kazan':				$partner_phone = '8 800 301-20-10';		break;
	case 'kg':					$partner_phone = '+7 (963) 298-99-42';	break;
	case 'krasnoyarsk':			$partner_phone = '+7 (391) 200-81-58';	break;
	case 'krdr':				$partner_phone = '+7 (964) 899-90-07 ';	break;
	case 'nn':					$partner_phone = '+7 (831) 414-34-84';	break;
	case 'novosibirskbo':		$partner_phone = '+7 (383) 319-15-59';	break;
	case 'omsk':				$partner_phone = '8 800 301-20-10';		break;
	case 'orenburg':			$partner_phone = '8 800 301-20-10';		break;
	case 'rnd':					$partner_phone = '8 800 301-20-10';		break;
	case 'samara':				$partner_phone = '+7 (960) 833-46-88';	break;
	case 'spb':					$partner_phone = '+7 (812) 611-11-48';	break;
	case 'sta':					$partner_phone = '8 800 301-20-10';		break;
	case 'tomsk':				$partner_phone = '8 800 301-20-10';		break;
	case 'ufa':					$partner_phone = '8 800 301-20-10';		break;
	case 'ggumarova':			$partner_phone = '+7 (727) 237-77-89';	break;
	case 'kz':					$partner_phone = '+7 (727) 237-77-89';	break;
	case 'zavod-':				$partner_phone = '8 800 301-20-10';		break;
	case 'zavod-chelyabinsk':	$partner_phone = '8 800 301-20-10';		break;
	case 'zavod-drb':			$partner_phone = '8 800 301-20-10';		break;
	case 'zavod-ekb':			$partner_phone = '8 800 700-56-24';		break;
	case 'zavod-kazan':			$partner_phone = '8 800 301-20-10';		break;
	case 'zavod-kg':			$partner_phone = '+7 (963) 298-99-42';	break;
	case 'zavod-krasnoyarsk':	$partner_phone = '+7 (391) 200-81-58';	break;
	case 'zavod-krdr':			$partner_phone = '+7 (964) 899-90-07';	break;
	case 'zavod-nn':			$partner_phone = '+7 (915) 944-25-02';	break;
	case 'zavod-novosibirskbo':	$partner_phone = '+7 (383) 319-15-59';	break;
	case 'zavod-rnd':			$partner_phone = '+7 (964) 899-90-07';	break;
	case 'zavod-samara':		$partner_phone = '+7 (960) 833-46-88';	break;
	case 'zavod-spb':			$partner_phone = '+7 (812) 611-11-48';	break;
	case 'zavod-sta':			$partner_phone = '8 800 301-20-10';		break;
	case 'zavod-ufa':			$partner_phone = '8 800 301-20-10';		break;
	case 'zavod-ggumarova':		$partner_phone = '+7 (727) 237-77-89';	break;
	case 'zavod-kz':			$partner_phone = '+7 (727) 237-77-89';	break;

	default:
	$partner_phone = '8 800 707 41 77';

}

$payment_redirect = '';

if( !empty($lead->cost) ){
	/*$intellectmoney_redirect = "<script>setTimeout(function(){location.href = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=455445&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC=Форум Героев&preference=bankCard'}, 1000);</script>";*/
	$payment_redirect = '<p><a href="https://shkola-biznesa-sine.timepad.ru/event/377993/" data-twf-placeholder="yes">Перейти к заказу билетов</a><script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="16277" data-timepad-widget-v2="event_register" src="https://timepad.ru/js/tpwf/loader/min/loader.js">(function(){return {"event":{"id":"377993"},"hidePreloading":true,"initialRoute":"button","buttonSettings":{"text":"Купить билет"}}; })();</script></p>';
}


/* Дефолтный обработчик */
/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = false;
/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = true;

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо, ваша заявка успешно отправлена.</h3>
	<p>Проверьте электронную почту, куда мы&nbsp;направили письмо с&nbsp;дальнейшими инструкциями.</p>
</div>
";

/* https://sd.synergy.ru/Task/View/98716 */
/* Для некоторых партнеров заменяем кнопку заказа билетов на ссылку http://synergyregions.ru */
if ( preg_match( '/^(ekb|kg|krdr|nn|novosibirskbo|orenburg|rnd|spb|sta|krasnoyarsk|ufa|drb|omsk|tomsk|kazan|chelyabinsk|samara|zavod-.*)$/i', $lead->partner ) ) {
	$config['user']['sendsuccess'] .= "<p><a href='http://synergyregions.ru?utm_source={$lead->land}' target='_blank' class='button'>Перейти на&nbsp;сайт</a></p>";
}

$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на предпринимательский форум «Герои российского бизнеса 2017»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_forumgeroev_2017.php';