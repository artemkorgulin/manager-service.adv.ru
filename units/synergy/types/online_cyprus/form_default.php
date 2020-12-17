<?php

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо! Ваша заявка отправлена.</h3>
	<p>В&nbsp;ближайшее время с&nbsp;вами свяжется наш консультант и&nbsp;ответит на&nbsp;все ваши вопросы</p>
</div>";

$config['ignore']['getresponse'] = false;

$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Добро пожаловать!";
$withPrice = "";

if( isset($_REQUEST['form']) && $_REQUEST['form'] == 'getpricelist' ){

	$withPriceList = "<br><a target='_blank' href='http://synergy.online/docs/price_ru.pdf'>Скачать прайс-лист</a>";

}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergy_online_cypr.php';
$config['mail']['smtp']['fromname'] = "Синергия Онлайн";

if( isset($lead->land) && ($lead->land == 'synergy_online_cypr_en') ) {

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Thank you! Your application has been sent.</h3>
		<p>Our consultant will get in&nbsp;touch with you in&nbsp;the nearest time to&nbsp;answer all of&nbsp;your questions</p>
	</div>";

	$config['mail']['smtp']['user']['subject'] = "Welcome!";

	if( isset($_REQUEST['form']) && $_REQUEST['form'] == 'getpricelist' ){

		$withPriceList = "<br><a target='_blank' href='http://synergy.online/docs/price_ru.pdf'>Get a price list</a>";

	}

	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergy_online_cypr_en.php';
	$config['mail']['smtp']['fromname'] = "Synergy Online";

}

?>