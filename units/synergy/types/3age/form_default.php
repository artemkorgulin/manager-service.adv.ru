<?php
{
		$config['ignore']['bitrix24'] 	= true;


		// Конфигуратор FormMessages
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>Наш менеджер свяжется с вами.</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";

		// Конфигуратор MessageForCallCentre
	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('reservation@3age.ru', 'rodin.rv@3age.ru'));
	$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда http://3age.ru/lp/landing/";
	$config['mail']['smtp']['cc']['message'] = "
				<p>Имя: <b>$lead->name</b>
				<br />Телефон: <b>$lead->phone</b>
				<br />Email: <b>$lead->email</b>
				<br />-----
				<br />Город: <b>$lead->city</b>
				<br />Источник: <b>$lead->source</b>
				<br />Адрес страницы: $lead->url
				<br />-----------------------------------------</p>
				<p style='font-size:11px;'>Реферер: $lead->refer</p>";

	// Адрес и имя для отправки писем
	$config['mail']['smtp']['from']		= "noreply@3age.ru";
	$config['mail']['smtp']['fromname']	= "Резиденция \"Третий Возраст\"";

	$config['ignore']['send_to_user']   = false;

}