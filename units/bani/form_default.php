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
		$config['user']['sendduplicate'] = "
		<div class='send-duplicate'>
			<h3>Вы уже отправляли сообщение!</h3>
			<p>Если вам не ответили или не перезвонили, пожалуйста, напишите нам еще раз, указав <a href='%s'>другой номер</a> телефона. Или позвоните по номеру: +7 (495) 532 52 90</p>
			<script>$('document').ready(function(){Hash.add('send','duplicate');});</script>
		</div>";

		// Конфигуратор MessageForCallCentre
	/*$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('baniclient@gmail.com'));

	if ($_REQUEST['version'] == 'v1') {
		$config['ignore']['bitrix24'] 	= true;
		$config['mail']['smtp']['cc']['emails'] = array(array('baniudachi@gmail.com'));
	}
	
	$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда Бани удачи";
	$config['mail']['smtp']['cc']['message'] = "
				<p>Имя: <b>$lead->name</b>
				<br />Телефон: <b>$lead->phone</b>
				<br />Email: <b>$lead->email</b>
				<br />Компания: <b>$lead->company</b>
				<br />Продукт: <b>$lead->product</b>
				<br />-----
				<br />Город: <b>$lead->city</b>
				<br />Источник: <b>$lead->source</b>
				<br />Адрес страницы: $lead->url
				<br />-----------------------------------------</p>
				<p style='font-size:11px;'>Реферер: $lead->refer</p>";

	// Адрес и имя для отправки писем
	$config['mail']['smtp']['from']		= "noreply@baniudachi.ru";
	$config['mail']['smtp']['fromname']	= "Бани удачи";*/

}