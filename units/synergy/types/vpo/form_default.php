<?php

if (strpos(".synergyonline.ru") === false) {
	$curlSms = curl_init("https://syn.su/smsResponse.php");
	curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curlSms, CURLOPT_POSTFIELDS, ["token" => "155f2ebf66e79d248cce9f9da4abda54", "type" => "synergy", "phone" => $lead->phone]);
	if ($_REQUEST['land'] != 'police') {
		$responseSms = curl_exec($curlSms);
	}
	curl_close($curlSms);
}

if (!empty($lead->link)) {
	$redirect = "<script>setTimeout(function(){ location.replace(\"{$lead->link}\"); }, 2000);</script>";
}


/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_vpo');



if ($_REQUEST['land'] == 'newbrand_2019') {
	$DefaultSuccessMessage = ($_REQUEST['form'] == 'get_catalog')
		? "<h3>Заявка успешно отправлена!</h3><script>setTimeout(function(){location.replace(\"http://synergy.ru/lp/thanks/\"); }, 1000);</script>"
		: '<h3>Заявка успешно отправлена!</h3><a href="https://synergy.ru/assets/upload/catalog/synergy_catalog.pdf?utm_campaign=catalog-0&utm_content=catalog-0&utm_medium=e_mail_chain_catalog&utm_source=maillist&utm_term=newbrand" target="_blank">Скачать каталог университета Синергия</a>';
}



if ($_REQUEST['land'] == 'cap-2-en') {
	$DefaultSuccessMessage = "
	<div class='send-success'>
		<h3>Your request has been sent successfully!</h3>
		<p>{$lead->name}, you have successfully registered for the event. Check your e-mail  <b>{$lead->email}</b>, there you will find a letter with further instructions.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
}


if ($_REQUEST['land'] == 'vpo-eng-long-v1' || $_REQUEST['land'] == 'vpo-eng-crazy-v1') {
	$DefaultSuccessMessage = "
	<div class='send-success'>
		<h3>Thank you!</h3>
		<p>Request is successfully placed! Our study consultant will get in touch with you to answer all your questions.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		<script>setTimeout(function(){ location.replace(\"http://synergy.ru/lp/_chunk/thanks_all/eng.php?lang=en\"); }, 2000);</script>
	</div>";
}



if ($_REQUEST['land'] == 'vpo-crazy' && $_REQUEST['version'] == 'v5' && $_REQUEST['partner'] == 'fomicheva') {
	$DefaultSuccessMessage = "
				<div class='send-success'>
								<h3>Заявка успешно отправлена!</h3>
								<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>

				</div>";
}
########################################
##### For https://sd.synergy.ru/task/view/49094  #####
########################################
if ($_REQUEST['land'] == 'cap-v2' && $_REQUEST['version'] == 'v2' or $_REQUEST['version'] == 'v3') {
	$DefaultSuccessMessage = "
				<div class='send-success'>
								<h3>Заявка успешно отправлена!</h3>
								<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>

				</div>";
}

if ($_REQUEST['land'] == 'cap-2' && $_REQUEST['partner'] == 'dp2_av') {
	$DefaultSuccessMessage = "
	<div class='send-success'>
	    <h3>Заявка успешно отправлена!</h3>
	    <p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>";
}

if ($_REQUEST['land'] == 'remarketing' && $_REQUEST['partner'] == 'avityuk') {
	$DefaultSuccessMessage = "
	<div class='send-success'>
	    <h3>Заявка успешно отправлена!</h3>
	    <p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>";
}

/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = $DefaultSuccessMessage;


if ($_REQUEST['land'] == 'yuridicheskij') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>
	<script>setTimeout(function(){location.replace(\"https://synergy.ru/lp/thanks/\"); }, 990);</script>";
}

if ($lead->land == 'lp_cdo' || $lead->land == 'lp_cdo_control_procurement__') {

	// Конфигуратор UserMail
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Добрый день!";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_cdo.php';

}

if (strpos($lead->land, 'lp_zao_new') !== false && $lead->form == 'top') {
	$config['user']['sendsuccess'] = "<script>setTimeout(function(){location.href='http://synergyonline.ru/r/my_demo/index.php'; }, 1);</script>";
}

if ('lp-zao-v5-dp2' == $lead->land) {
	$lead->source = 'vuzopedia';
}
