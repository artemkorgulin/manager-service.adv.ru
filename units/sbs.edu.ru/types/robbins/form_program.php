<?php
/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на событие: Тони Роббинс впервые в России";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_robbins.php';

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p class='send-success__text'>Если программа не открылась в новой вкладке, Вы можете скачать программу форума по <a href='https://synergyforum.ru/docs/program.pdf' target='_blank' class='send-success__program-link'><span>ссылке</span></a></p>
	</div>
	<script>$('.send-success__program-link span').click();</script>";