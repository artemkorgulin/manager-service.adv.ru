<?php
{
	$config['ignore']['bitrix24'] = false;

	/* Конфигуратор FormMessages */
	$config['user']['sendsuccess'] = "<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Наш менеджер свяжется с вами.</p>
	</div>";

	if($lead->form == 'callme') {
        $config['mail']['smtp']['cc']['subject'] = "Заказ звонка с mollafitness.ru";
	// Конфигуратор UserMail
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>Мы перезвоним вам по номеру <b>{$lead->phone}</b>, в ближайшее время, держите телефон под рукой.</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}elseif($lead->form == 'subscription') {
        $config['mail']['smtp']['cc']['subject'] = "Подписка на рассылку с mollafitness.ru";
	// Конфигуратор UserMail
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка отправлена!</h3>
			<p>Вы успешно подписались на нашу рассылку.</p>
		</div>";
	}elseif($lead->form == 'get_training') {
        $config['mail']['smtp']['cc']['subject'] = "Запись на тренировку с mollafitness.ru";
    }elseif($lead->form == 'card') {
        $config['mail']['smtp']['cc']['subject'] = "Заказ карты с mollafitness.ru";
    }

	/* Конфигуратор MessageForCallCentre */
	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('Molla-kate@yandex.ru','a1cof@yandex.ru'));

	if(strlen(trim($lead->email)))
		$email = "Email: <b>".$lead->email."</b><br />";
    if(strlen(trim($lead->phone)))
        $phone = "Телефон: <b>".$lead->phone."</b><br />";
    if(strlen(trim($lead->product)))
        $product = "Карта: <b>".$lead->product."</b><br />";

	$config['mail']['smtp']['cc']['message'] = "
		Имя: <b>$lead->name</b><br />".
        $phone.
        $email.
        $product;

		/* Адрес и имя для отправки писем */
		$config['mail']['smtp']['from']		= "Molla-kate@yandex.ru";
		$config['mail']['smtp']['fromname']	= "mollafitness";
	}