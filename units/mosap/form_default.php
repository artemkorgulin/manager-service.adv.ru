<?php
	/* Конфигуратор FormMessages */
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		{$DefaultRedirect}
	</div>";

	/* Конфигуратор GetResponse */
	$config['ignore']['getresponse']    = true;
	$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_mapper');