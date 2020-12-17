<?php
#########################
##### Консалтинг #####
#########################

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p> <br />
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было base

// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Консалтинг {$lead->program}";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_consalt.php';