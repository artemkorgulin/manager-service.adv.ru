<?php
$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = true;

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'nyk');

$program_file = ''; /* PDF-файл программы в письмах */

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

$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Global Forum Дубай 2017";


$default_sendsuccess = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена. <br>
		Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;неё подтверждение вашей регистрации.
	</p>
</div>
';

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

	$config['mail']['smtp']['user']['subject'] = "Your registration for Synergy Global Forum Dubai 2017";
}



/* Для временных заглушек сайтов */
if ( $lead->land == 'sgf2017-lite-ru' ) {
	$config['ignore']['send_to_user'] = false;

	$default_sendsuccess = '
	<div class="send-success">
		<p>
			Спасибо! Ваша заявка отправлена. В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами и&nbsp;подробно расскажет о&nbsp;Synergy Global Forum Дубай 2017.
		</p>
	</div>
	';
}
elseif ( $lead->land == 'sgf2017-lite-en' ) {
	$config['ignore']['send_to_user'] = false;

	$default_sendsuccess = '
	<div class="send-success">
		<p>
			Thank you! Your request has been sent. We&rsquo;ll call you back and tell mоre about Synergy Global Forum Dubai 2018.
		</p>
	</div>
	';
}

$config['user']['sendsuccess'] = $default_sendsuccess;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_dubai/default.php';
