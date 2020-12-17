<?php 
###############################
##### Арсенал #####
###############################

// Конфигуратор FormMessages

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, спасибо за оставленную заявку, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>";
		

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = false;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : '');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : ''); // пока пустые


// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «{$lead->program}»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_arsenal.php';

