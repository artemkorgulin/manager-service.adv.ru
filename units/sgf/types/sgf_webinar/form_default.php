<?php
/* Defaults */
$partner_phone = '8 800 707 41 77';

$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = false;

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'nyk');

/* http://synergyglobal.ru/webinar/.../ */
$config['mail']['smtp']['fromname'] = "Synergy Global Forum";
$config['mail']['smtp']['from'] = "notice@synergyglobal.ru";
$config['mail']['smtp']['user']['subject'] = "Поздравляем! Вы зарегистрированы на вебинар " . $lead->speaker;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_webinar/default.php';

$default_sendsuccess_addon = '';
$default_sendsuccess = '
<div class="send-success">
	<p>
		Спасибо за&nbsp;регистрацию!<br>
		Вы&nbsp;получите подтверждение регистрации на&nbsp;вашу электронную почту.
	</p>
</div>
';


/* Языки */
/* http://sgf2017.com/webinar/.../ */
if ( $_REQUEST['lang'] == 'en' ) {
	$config['mail']['smtp']['from'] = "notice@sgf2017.com";
	$config['mail']['smtp']['user']['subject'] = "Congratulations! You are registered for the " . $lead->speaker . " webinar";

	$default_sendsuccess = '
	<div class="send-success">
		<p>
			Thank you for your registration!<br>
			Check your email for the confirmation letter.
		</p>
	</div>
	';
}


/* Ленды */
if ( $lead->land == 'sgf2017_webinar_gumarova' ) {
	$config['mail']['smtp']['fromname'] = "Synergy Global Forum Алматы";
}

elseif ( $lead->land == 'sgf2017_presentation' ) {
	$config['mail']['smtp']['user']['subject'] = "Вы зарегистрированы на презентацию для партнеров SGF New York 2017";
}

elseif ($lead->land == 'sgf2017_webinar_kurzweil_en' || $lead->land == 'sgf2017_webinar_kurzweil_ru') {
	$config['ignore']['getresponse'] = true;
	$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'SGF2017');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'web_kurzweil');
}

elseif ($lead->land == 'sgf2017_webinar_vainerchuk_en' || $lead->land == 'sgf2017_webinar_vainerchuk_ru') {
	$config['ignore']['getresponse'] = true;
	$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'SGF2017');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'web_vainerchuk');
}

elseif (stripos($lead->land, 'sgf2019_webinar_') !== false) {
	$config['ignore']['getresponse'] = true;
	$link = 'https://synergyglobal.ru/';
	$default_sendsuccess = "
		<div class='send-success'>
			<p>
				Спасибо!<br><br>
				Ваша заявка отправлена, подтверждение регистрации придет вам на почту.
			</p>
			<script>setTimeout(function(){location.href = '{$link}'}, 500);</script>
		</div>
		";
}


/* Финальный конфиг */
$config['user']['sendsuccess'] = $default_sendsuccess;