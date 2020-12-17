<?php
$config['ignore']['bitrix24'] = fasle;

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо!</h3>
		<p>Заявка успешно отправлена.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";


// Конфигуратор send_to_user
$config['ignore']['send_to_user'] 	= false;


// Конфигуратор MessageForCallCentre
$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('kmuraveva@s-university.ru')); //kmuraveva@s-university.ru
	$config['mail']['smtp']['cc']['subject'] = "Заказ звонка — Департамент молодежной политики | Университет СИНЕРГИЯ";
	$config['mail']['smtp']['cc']['message'] = "
		<p>ФИО<br />
		<b>$lead->name</b></p>

		<p>Телефон<br />
		<b>$lead->phone</b></p>

		--
		Это сообщение отправлено с сайта Департамент молодежной политики (http://mol.synergy.ru)
	";