<?php

// В форме есть скрытое (display none) поле field, которое должно быть пустым. Если оно не пустое, значит заполнено ботом - не обрабатываем дальше.
if ($_REQUEST['field'] != '') {
	echo 'Спасибо!';
	exit;
}

// из-за спамеров вынуждены принимать только ajax-запросы
$is_ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if (!$is_ajax) {
	echo 'Спасибо!';
	exit;
}

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
		{$DefaultRedirect}
	</div>";