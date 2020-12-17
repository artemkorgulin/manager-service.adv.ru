<?php
/* Конфигуратор GetResponse */
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sng');

/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = $DefaultSuccessMessage;

if( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Your applicaton was sent successfully!</h3>
		<p>Check your email <b>{$lead->email}</b> and follow further instructions</p>
	</div>
	";
}
