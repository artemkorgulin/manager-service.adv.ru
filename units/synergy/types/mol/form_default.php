<?php
$config['ignore']['bitrix24'] = fasle;

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо!</h3>
		<p>Ваше сообщение было отправлено успешно.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";


// Конфигуратор send_to_user
$config['ignore']['send_to_user'] 	= false;
$config['mail']['smtp']['user']['subject'] 	= "Анкета (краткая) — Департамент молодежной политики | Университет СИНЕРГИЯ";
$config['mail']['smtp']['user']['message'] 	= "
	<div style=\"font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;\">
  	<div style=\"margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;\">
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Ваше сообщение было отправлено успешно.</p>
			<hr style=\"color: #E5E5E5;\">
			<p style=\"color:#505050;\"><i>С уважением, команда Synergy</i><br>
			Тел. <a href=\"tel:88001001746\">8 (800) 100 17 46</a><br>
			Email: <a href=\"mailto:top10_mat11@synergy.ru\">top10_mat11@synergy.ru</a></p>
   	</div>
  	<div style=\"text-align: center; margin-top: 15px; color:#909090; font-size:11px;\">© 2016. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href=\"tel:+74958001001\">+7 (495) 800 10 01</a></div>
	</div>
	";


// Конфигуратор MessageForCallCentre
$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('kmuraveva@s-university.ru')); //kmuraveva@s-university.ru
	$config['mail']['smtp']['cc']['subject'] = "Университет СИНЕРГИЯ | Департамент молодежной политики — Анкета (краткая)";
	$config['mail']['smtp']['cc']['message'] = "
		<p>ФИО<br />
		<b>$lead->name</b></p>

		<p>Телефон<br />
		<b>$lead->phone</b></p>

		<p>E-mail<br />
		<b>$lead->email</b></p>

		--
		Это сообщение отправлено с сайта Департамент молодежной политики (http://mol.synergy.ru)
	";