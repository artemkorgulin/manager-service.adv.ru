<?php
#####################
##### MBA ленды #####
#####################
/* Редиректы после отправки сообщения в зависимости от ленда */
if (!empty($lead->partner)) {
	$partner = '&partner='.$lead->partner;
}

$RedirectLink = array(
    // $link = 'http://sbs.edu.ru/land/mba/thanks.php?'.$partner
    // это все равно юнит для регионов
    $link = 'http://synergyregions.ru/lp/mba/thanks.php?'.$partner
	/*

	Теперь одна стр thanks везде, сделано по этой задаче https://sd.synergy.ru/Task/View/41237

	'inter' => 'thanks.php',
	'Mini-MBA' => 'thanks.php',
	'mba-long' => 'thanks.php',
    'minimba' => 'thanks.php',
	'mba-pocket' => 'thanks.php',
	'mba-finance' => 'thanks.php',
	'fitnes-industrii' => 'thanks.php',
	'mba-women' => 'thanks.php',
	'mba-strategiya-liderstva' => 'thanks.php',
	'corporate_programs' => 'thanks.php',
	'tax-consulting' => 'thanks.php',

	'univer-inter' => 'thanks.php',
	'univer-Mini-MBA' => 'thanks.php',
	'univer-mba-long' => 'thanks.php',
	'univer-mba-pocket' => 'thanks.php',
	'univer-mba-finance' => 'thanks.php',
	'univer-mba-women' => 'thanks.php',
	'univer-mba-strategiya-liderstva' => 'thanks.php',
	'univer-corporate_programs' => 'thanks.php',
	'univer-tax-consulting' => 'thanks.php',
	'univer-mba-finance' => 'thanks.php',
	'dubai-short' => 'thanks.php',*/
	);

if ($lead->land == 'synergy-demo-version-emba') {
    $link = 'http://synergy.ru/lp/mba/thanks/thanks.php';
}

if (!empty($RedirectLink[$lead->land])) {
	$link = $RedirectLink[$lead->land];
}
if (!empty($lead->link)) {
	$link = $lead->link;
}
if (!empty($link)) {
	$redirect = "<script>setTimeout(function(){location.replace('{$link}')}, 500);</script>";
}

if ($lead->form == 'noredirect') {
	$redirect = "";
}

/* Конфигуратор GetResponse */

$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sub_mba');

/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>В&nbsp;ближайшее время наш&nbsp;менеджер свяжется с&nbsp;вами по&nbsp;телефону <b>{$lead->phone}</b>, чтобы ответить на&nbsp;все вопросы.</p>
		{$redirect}
		<script>$('document').ready(function(){Hash.add('send','ok')});</script>
	</div>";
