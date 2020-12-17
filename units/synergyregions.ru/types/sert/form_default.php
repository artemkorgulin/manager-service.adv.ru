<?php
###########################
##### Сертификат 5000 #####
###########################
	if(isset($_REQUEST['partner']) AND ($_REQUEST['partner'] == 'return')){
		// Конфигуратор GetResponse
		$config['ignore']['getresponse']    = true;
		$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
		$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'return');

		// Конфигуратор UserMail
		$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>В ближайшее время наш менеджер свяжется с вами по телефону <b>{$lead->phone}</b>, чтобы ответить на все вопросы.</p>
				<script>$('document').ready(function(){Hash.add('send','ok');});</script>
			</div>";
	}
	if(isset($_REQUEST['partner']) AND ($_REQUEST['partner'] == 'spb')){
		// Конфигуратор GetResponse
		$config['ignore']['getresponse']    = true;
		$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
		$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'spb');

		// Конфигуратор UserMail
		$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>В ближайшее время наш менеджер свяжется с вами по телефону <b>{$lead->phone}</b>, чтобы ответить на все вопросы.</p>
				<script>$('document').ready(function(){Hash.add('send','ok');});</script>
			</div>";
	}
	else{
		// Конфигуратор GetResponse
		$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
		$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
		$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main');

        // Конфигуратор UserMail
        $config['ignore']['send_to_user']   = true;
        $config['mail']['smtp']['user']['subject']  = "Готово! Сертификат на 5000 рублей успешно зарегистрирован в системе {$lead->program}";
        $config['mail']['smtp']['user']['message'] 	= include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/sbs.edu.ru/letters/mail_sert.php';

		// Конфигуратор UserMail
		$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>В ближайшее время наш менеджер свяжется с вами по телефону <b>{$lead->phone}</b>, чтобы ответить на все вопросы.</p>
				<script>$('document').ready(function(){Hash.add('send','ok');});</script>
			</div>";
	}