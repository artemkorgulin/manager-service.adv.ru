<?php 
###############################
##### Synergy Акселератор #####
###############################

// Конфигуратор FormMessages
if($_REQUEST['land'] == 'synergyakselerator' || $_REQUEST['land'] == 'synergystartup' || $_REQUEST['land'] == 'synergystartup-v3') {
	if($_REQUEST['form'] == 'callme'){
		$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>В ближайшее время, мы вам перезвоним!</p>
	</div>";
	} else if($_REQUEST['partner'] == 'oberezina'){
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
		</div>";
	}	else{
		$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
		{$intellectmoney_redirect_aksel}
	</div>";
	}
}
else{
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
		{$intellectmoney_redirect}
	</div>";
}

if ($_REQUEST['land'] == 'synergystartup_miniland') 
{
  $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
	</div>";
}


// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было base

// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;

if($_REQUEST['land'] == 'synergyakselerator') {
	if($_REQUEST['form'] != 'callme') {
		$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на программу Synergy Акселератор";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_aksel.php';
	}
} 
if($_REQUEST['land'] == 'lukashenko-sm-v3') {
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на программу ТАЙМ-МЕНЕДЖМЕНТ ДЛЯ ДЕТЕЙ (8–15 ЛЕТ)";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_lukashenko.php';

} 
elseif($_REQUEST['land'] == 'synergystartup' || $_REQUEST['land'] == 'synergystartup_miniland'){
	if($_REQUEST['form'] != 'callme') {
		$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на программу {$_REQUEST['program']}";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_startup.php';
	}
	if($_REQUEST['partner'] == 'oberezina'){
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_startup_nopay.php';
	}
}
elseif($_REQUEST['land'] == 'synergymbapresident'){
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на Executive MBA «Президентская программа»";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_president.php';
}
elseif($_REQUEST['land'] == 'belochkina'){
  $config['mail']['smtp']['user']['subject'] = "Успешная регистрация на онлайн-практикум Анастасии Белочкиной";
	if($_REQUEST['partner'] == 'oberezina') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
		</div>";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_belochkina_nopay.php';
	} else {
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_belochkina.php';
	}
}
