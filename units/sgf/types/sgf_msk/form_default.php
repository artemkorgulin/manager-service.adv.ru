<?php

/* Defaults */

$config['ignore']['send_to_user'] = false; /* https://sd.synergy.ru/Task/View/293043 */
$config['ignore']['getresponse'] = true;
$config['mail']['smtp']['fromname'] = "Школа Бизнеса «Синергия»";
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Global Forum Москва 2018";

$default_grcampaign = 'e_mail_chain_sgf2017';
$program_file = 'http://synergyglobal.ru/files/sgf-program.pdf'; /* PDF-файл программы в письмах */
$partner_phone = '8 800 707 41 77';

$sendsuccess_button = '';
$default_sendsuccess = "
<div class='send-success'>
<p>
Спасибо! Ваша заявка отправлена. <br>

</p>
{$sendsuccess_button}
<script>$('[href=\"#popup-tickets-all\"]:first').trigger('click');</script>
</div>
";


/* Языки */

if ( $_REQUEST['lang'] == 'en' ) {
	$default_sendsuccess = '
	<div class="send-success">
	<p>
	Thank you!<br>
	Your application has been sent. Check your email: we&nbsp;sent you the confirmation of&nbsp;registration.
	</p>
	</div>
	';

	$partner_phone = '+1 (646) 847 97 83';

	$config['mail']['smtp']['user']['subject'] = "Your registration for Synergy Global Forum Moscow 2017";
}


/* Подленды */

if ( $lead->land == 'sgf2017_almaty' ) {
	$default_grcampaign = 'kz_sgf_sub';
}

elseif ( $lead->land == 'sgf2018_habib' ) {
	$config['ignore']['send_to_user'] = false;

	$default_sendsuccess = '
	<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Чтобы завершить регистрацию на участие в конкурсе сделайте репост этой записи и до встречи на форуме!</p>
	</div>
	';
}

elseif ($lead->land == 'sgf_test_dozvon') {
	$default_sendsuccess = "
	<div class='send-success'>
	<p>
	Спасибо! Ваша заявка отправлена.
	</p>
	</div>
	";
}

elseif ( $lead->land == 'sgf2017-lite-ru' ) {
	$config['ignore']['send_to_user'] = false;

	$default_sendsuccess = '
	<div class="send-success">
	<p>
	Спасибо! Ваша заявка отправлена. В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами и&nbsp;подробно расскажет о&nbsp;Synergy Global Forum Москва 2017.
	</p>
	</div>
	';
}

elseif ( $lead->land == 'sgf2017-lite-en' ) {
	$config['ignore']['send_to_user'] = false;

	$default_sendsuccess = '
	<div class="send-success">
	<p>
	Thank you! Your request has been sent. We&rsquo;ll call you back and tell mоre about Synergy Global Forum Moscow 2017.
	</p>
	</div>
	';
}

/* http://synergyglobal.ru/top10/ : https://sd.synergy.ru/Task/View/136509 */
elseif ( $lead->land == 'sgf2017_msk_top10' ) {
	include_once 'land_sgf2017_msk_top10.php';
}

/* https://sd.synergy.ru/Task/View/141021 */
elseif ( $lead->land == 'sgf2017_msk' && ( $lead->form == 'bottom' || $lead->form == 'popup-get-video' ) ) {
	$config['newsletter']['getresponse']['account'] = 'synergy';
	$config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_mail_sgfpodpis_msk';

	include_once 'land_sgf2017_msk_top10.php';
}


/* Партнеры */

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
}


/* Версии */

/* https://sd.synergy.ru/Task/View/150432 */
if ( $lead->version == 'sgf_dp1' ) {
	$config['ignore']['getresponse'] = false;
}

elseif ( $lead->version == 'temperra' ) {
	$config['ignore']['send_to_user'] = false;
	$config['ignore']['bitrix24'] = false;

	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('hello@temperra.com'), );
	$config['mail']['smtp']['cc']['subject'] = "Заявка с сайта synergyglobal.ru";
	$config['mail']['smtp']['cc']['message'] = "
	<p>Имя: <b>$lead->name</b>
	<br />Телефон: <b>$lead->phone</b>
	<br />Email: <b>$lead->email</b>
	<br />-----------------------------------------</p>";
}

elseif ( $lead->version == 'rsv' || $lead->version == 'tony' ) {
	$default_sendsuccess .= '<script>location.href = "/price/";</script>'; /* https://sd.synergy.ru/Task/View/343940 */
}

/* Если передан link, делаем редирект (например, для https://synergyglobal.ru/mobile/) */
if ( $lead->link ) {
	$default_sendsuccess .= "<script>location.href = '{$lead->link}';</script>";
}



/* Финальный конфиг */

$config['user']['sendsuccess'] = $default_sendsuccess;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/default.php';

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : $default_grcampaign);
