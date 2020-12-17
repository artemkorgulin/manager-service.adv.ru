<?php
/* Конфигуратор FormMessages */

/* Конфиг по умолчанию */
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Your request has been sent successfully!</h3>
	<p>{$lead->name}, you have successfully registered for the event. Check your e-mail  <b>{$lead->email}</b>, there you will find a letter with further instructions.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";

// $config['user']['sendduplicate'] = "
// <div class='send-duplicate'>
// 	<h3>You have already sent a message!</h3>
// 	<p>If you do not respond or did not call back, please send the message again, and putting in <a href='%s'>other number</a> phone. Or call: +971 44206699</p>
// 	<script>$('document').ready(function(){Hash.add('send','duplicate');});</script>
// </div>";

/* Конфиг по условию */
if(isset($_REQUEST['land']) AND ($_REQUEST['land'] == 'cis')) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Your applicaton was sent successfully!</h3>
		<p>Check your email <b>{$lead->email}</b> and follow further instructions</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
}

if($lead->version == 'v1') {

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Your request has been sent successfully!!</h3>
		<p>We will get in touch with you shortly. Thank you for your interest!</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

	/* Убрано на заявке http://sd.synergy.ru/Task/View/63872 */
	/*$unic = substr(uniqid(),-3);
	// Отправка смс-сообщения пользователю
	$config['ignore']['vrf_by_phone'] 	 = true;
	$config['vrf']['sms']['smsc']['mes'] = "Your unique code: 043-{$unic} Sunergy Dubai Campus";	*/
}

/* Конфигуратор GetResponse */
$config['ignore']['getresponse']    = false;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_vpo');
