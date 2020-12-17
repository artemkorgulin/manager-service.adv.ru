<?php
	/* Конфигуратор FormMessages */
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо!</h3>
		<p>База открыта для <b>{$lead->email}</b>.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

	/* Конфигуратор GetResponse */
	$config['ignore']['getresponse']    = true;
	$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'egemetr');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_ref');
	
	// Не отправлять в Битрикс24 если содержит только мыло
	$config['ignore']['bitrix24'] = false;
