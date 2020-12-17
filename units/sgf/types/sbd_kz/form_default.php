<?php
$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = true;

$default_grcampaign = 'e_mail_chain_almaty_bd';

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : $default_grcampaign);

$program_file = 'http://synergyglobal.kz/pdf/sgf2017_almaty_program_ru.pdf'; /* PDF-файл программы в письмах */
$program_file2 = 'http://synergyglobal.kz/business/pdf/Synergy_Business_Day_Almaty_2018.pdf'; /* PDF-файл программы в письмах */

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
}

$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на Synergy Global Forum 2018 в Алматы";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sbd_kz/default.php';


/*$sendsuccess_button = "
<p>Переход на систему оплаты...</p>
<script>setTimeout(function(){ location.href = ''; }, 500);</script>
";*/

//$sendsuccess_button = ""

$sendsuccess = "
<div class='send-success'>
<p>
Спасибо! Ваша заявка отправлена. <br>
Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;неё подтверждение вашей регистрации.
</p>
<a class='button button1 fancybox' href='#popup-tickets'>Выбрать билет</a>
<script type='text/javascript'>
	setTimeout(function(){
		$('a[href=\"#popup-tickets\"]').click();
	}, 500);
</script>
<br>
</div>
";


if ($lead->form == 'study-speical') {
	$sendsuccess = "
	<div class='send-success'>
	<p>
	<b>Спасибо!</b> Ваша заявка отправлена. <br>
	В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами и&nbsp;расскажет, как приобрести билеты по&nbsp;студенческому спецпредложению.
	</p>
	</div>
	";
}

if ($lead->land == 'sgf2018_astana2018') {
	$sendsuccess = "
	<div class='send-success'>
	<p>
	<b>Спасибо!</b> Ваша заявка отправлена. <br>
	В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами.
	</p>
	</div>
	";
}

if ($lead->form == 'kz-national') {
	$sendsuccess = "
	<div class='send-success'>
	<p>
	<b>Спасибо!</b><br>
	Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время и&nbsp;расскажет, как приобрести билет по&nbsp;специальной цене.
	</p>
	</div>
	<script>$('[href=\"#popup-tickets\"]').first().click();</script>
	";
}

if ($lead->form == 'program-bd') {
	$sendsuccess = "
	<div class='send-success'>
	<p>
	<b>Спасибо!</b> Ваша заявка отправлена. <br>
		Проверьте свою электронную почту, программа Synergy Business Day 2018 должна прийти с минуты на минуту.. 
	</p>
	</div>
	";
}


$config['user']['sendsuccess'] = $sendsuccess;


