<?php
{	
		$config['ignore']['bitrix24'] 	= false;
		

		// Конфигуратор FormMessages    
		$config['user']['sendsuccess'] = "
		<div class='collback-final send-success'>
			<div class='popup-title'>Отлично</div>
			<div class='final-text'>ваша заявка принята, мы свяжемся с вами</div>
			<a class='button close-link'>закрыть окно</a>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
		$config['user']['sendduplicate'] = "
		<div class='send-duplicate'>
			<h3>Вы уже отправляли сообщение!</h3>
			<p>Если вам не ответили или не перезвонили, пожалуйста, напишите нам еще раз, указав <a href='%s'>другой номер</a> телефона. Или позвоните по номеру: +7 (495) 663 9373</p>
			<script>$('document').ready(function(){Hash.add('send','duplicate');});</script>
		</div>";
		$DefaultConfigMessage = "
			<p>Имя: <b>$lead->name</b>
					<br />Телефон: <b>$lead->phone</b>
					<br />Email: <b>$lead->email</b>
					<br />Дата посещения: <b>{$_REQUEST['date']}</b>
					<br />Количество человек: <b>{$_REQUEST['number']}</b>
					<br />Дополнительная информация: <b>{$_REQUEST['message']}</b>
					<br />Программа: <b>$lead->program</b>
					<br />-----
					<br />Город: <b>$lead->city</b>
					<br />Источник: <b>$lead->source</b>
					<br />Адрес страницы: $lead->url
					<br />-----------------------------------------</p>
					<p style='font-size:11px;'>Реферер: $lead->refer</p>";
		if($_REQUEST['form'] == 'Заявка на участие') {
			$DefaultConfigMessage = "
					<p>Имя: <b>$lead->name</b>
					<br />Телефон: <b>$lead->phone</b>
					<br />Email: <b>$lead->email</b>
					<br />Город: <b>{$_REQUEST['user_city']}</b>
					<br />Название программы: <b>$lead->program</b>
					<br />Количество детей: <b>{$_REQUEST['number_child']}</b>
					<br />Количество сопровождающих: <b>{$_REQUEST['number_accompanying']}</b>
					<br />Продолжительность (дней): <b>{$_REQUEST['duration']}</b>
					<br />Интересующие вопросы (пожелания к организации программы): <b>{$_REQUEST['message']}</b>
					<br />-----
					<br />Город: <b>$lead->city</b>
					<br />Источник: <b>$lead->source</b>
					<br />Адрес страницы: $lead->url
					<br />-----------------------------------------</p>
					<p style='font-size:11px;'>Реферер: $lead->refer</p>";
		}
		// Конфигуратор MessageForCallCentre
	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('info@synergytravel.ru'));
	$config['mail']['smtp']['cc']['subject'] = "{$_REQUEST['form']}";
	$config['mail']['smtp']['cc']['message'] = $DefaultConfigMessage;
	// Адрес и имя для отправки писем
	$config['mail']['smtp']['from']		= "noreply@synergytravel.ru";
	$config['mail']['smtp']['fromname']	= "Центр образовательного туризма";

}